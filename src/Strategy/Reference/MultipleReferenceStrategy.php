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

class MultipleReferenceStrategy extends AbstractReferenceStrategy implements ReferenceStrategy
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
            Entity\MultipleEntityStrategy::getEntityName($iblockId),
            Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
                ->whereIn("ref.IBLOCK_PROPERTY_ID", [$dto->getId()])
        ))->configureJoinType($join);
        $references[] = new Model\TableReference('multiple', $middleField, $tempReference);

        return $references;
    }

    public function createFields(DTO\ReferenceDTO $dto): array
    {
        $fields = [];
        $code = $dto->getCode();
        $type = $dto->getType();

        if ($type == "S" || $type == "N") {
            $fields[] = sprintf('%s.ID', $code);
            $fields[] = sprintf('%s.VALUE', $code);
        }else{
            $fields[] = sprintf('%s', $code);
        }

        return $fields;
    }
}
