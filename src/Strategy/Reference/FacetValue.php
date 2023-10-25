<?php

namespace alekseikovrigin\qubixqueries\Strategy\Reference;

use alekseikovrigin\qubixqueries\DTO;
use alekseikovrigin\qubixqueries\DTO\ReferenceDTO;
use alekseikovrigin\qubixqueries\Model\TableReference;
use alekseikovrigin\qubixqueries\Strategy\Entity;
use alekseikovrigin\qubixqueries\Model;
use alekseikovrigin\qubixqueries\Service;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class FacetValue extends AbstractReferenceStrategy implements ReferenceStrategy
{
    /**
     * @param ReferenceDTO $dto
     * @return TableReference[]
     */
    public function createReference(DTO\ReferenceDTO $dto): array
    {
        $code = $dto->getCode();
        $type = $dto->getType();
        $iblockId = $dto->getIblockId();
        $join = $dto->getJoin();

        $references = [];

        $middleField = $code;
        $tempReference = (new Reference(
            $middleField,
            Entity\FacetValueEntityStrategy::getEntityName($iblockId),
            Join::on("this.VALUE", 'ref.ID')
                ->whereIn("this.FACET_ID", [$dto->getId() * 2])
        ))->configureJoinType($join);

        $references[] = new Model\TableReference('facetvalue', $code, $tempReference);

        return $references;
    }

    public function createFields(DTO\ReferenceDTO $dto): array
    {
        $fields = [];
        $code = $dto->getCode();
        $type = $dto->getType();
        $fields[] = sprintf('%s.ID', $code);
        $fields[] = sprintf('%s.VALUE', $code);
        return $fields;
    }
}
