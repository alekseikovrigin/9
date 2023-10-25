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

class FacetReferenceStrategy extends AbstractReferenceStrategy implements ReferenceStrategy
{
    /**
     * @param ReferenceDTO $dto
     * @return TableReference[]
     */
    public function createReference(DTO\ReferenceDTO $dto): array
    {
        $id = $dto->getId();
        $code = $dto->getCode();
        $type = $dto->getType();
        $multiple = $dto->getMultiple();
        $iblockId = $dto->getIblockId();
        $join = $dto->getJoin();

        $references = [];

        $middleField = "PROPERTY_$code";
        $tempReference = (new Reference(
            $middleField,
            Entity\FacetEntityStrategy::getEntityName($iblockId),
            Join::on('this.ID', 'ref.ELEMENT_ID')
                ->whereIn("ref.FACET_ID", [$dto->getId() * 2])
        ))->configureJoinType($join);

        $references[] = new Model\TableReference('facet', $code, $tempReference);

        $tempReference = (new Reference(
            $code,
            Service\ReferenceManager::getReferenceClass($type),
            Join::on("this.$middleField.VALUE", 'ref.ID')
                ->whereIn("this.$middleField.FACET_ID", [$dto->getId() * 2])
        ))->configureJoinType($join);

        $references[] = new Model\TableReference('facet', $code, $tempReference);

        return $references;
    }

    public function createFields(DTO\ReferenceDTO $dto): array
    {
        $fields = [];
        $code = $dto->getCode();
        $type = $dto->getType();
        $fields[] = sprintf('%s', $code);
        return $fields;
    }
}