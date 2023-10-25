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

class SingleReferenceStrategy extends AbstractReferenceStrategy implements ReferenceStrategy
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

        $tempReference = (new Reference(
            'PROPERTY_S',
            Entity\SingleEntityStrategy::getEntityName($iblockId),
            Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
        ))->configureJoinType($join);
        $references[] = new Model\TableReference('single', 'PROPERTY_S', $tempReference);

        return $references;
    }

    public function createFields(DTO\ReferenceDTO $dto): array
    {
        $fields = [];
        $code = $dto->getCode();
        $type = $dto->getType();
        $fields[] = sprintf('PROPERTY_S.%s', $code);
        return $fields;
    }

    public function createFilterFields(DTO\ReferenceDTO $dto): array
    {
        $fields = [];
        $code = $dto->getCode();
        $value = $dto->getValue();

        $fields[sprintf('PROPERTY_S.%s', $code)] = $value;

        return $fields;
    }
}
