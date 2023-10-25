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

class TypeInFacet extends AbstractTypeReferenceStrategy implements ReferenceStrategy
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
            Service\ReferenceManager::getReferenceClass($type),
            Join::on("this.VALUE", 'ref.ID')
                ->whereIn("this.FACET_ID", [$dto->getId() * 2])
        ))->configureJoinType($join);

        $references[] = new Model\TableReference('inner', $code, $tempReference);


        return $references;
    }
}
