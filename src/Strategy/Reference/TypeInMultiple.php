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

class TypeInMultiple extends AbstractTypeReferenceStrategy implements ReferenceStrategy
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


        $middleField = "PROPERTY_$code";

        $tempReference = (new Reference(
            $middleField,
            Entity\MultipleEntityStrategy::getEntityName($iblockId),
            Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
                ->whereIn("ref.IBLOCK_PROPERTY_ID", [$dto->getId()])
        ))->configureJoinType($join);
        $references[] = new Model\TableReference('multiple', $middleField, $tempReference);

        $tempReference = (new Reference(
            $code,
            Service\ReferenceManager::getReferenceClass($type),
            Join::on("this.$middleField.VALUE", 'ref.ID')
                ->whereIn("this.$middleField.IBLOCK_PROPERTY_ID", [$dto->getId()])
        ))->configureJoinType($join);
        $references[] = new Model\TableReference('multiple', $code, $tempReference);

        return $references;
    }
}
