<?php

namespace alekseikovrigin\qubixqueries\Strategy\Reference;

use alekseikovrigin\qubixqueries\DTO;
use alekseikovrigin\qubixqueries\DTO\ReferenceDTO;
use alekseikovrigin\qubixqueries\Model\TableReference;
use alekseikovrigin\qubixqueries\Strategy\Entity;
use alekseikovrigin\qubixqueries\Model;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;

class ElementReferenceStrategy extends AbstractReferenceStrategy implements ReferenceStrategy
{
    /**
     * @param ReferenceDTO $dto
     * @return TableReference[]
     * @throws ArgumentException
     * @throws SystemException
     */
    public function createReference(DTO\ReferenceDTO $dto): array
    {
        $code = $dto->getCode();
        $type = $dto->getType();
        $iblockId = $dto->getIblockId();
        $join = $dto->getJoin();

        $references = [];

        $middleField = "ELEMENT";
        $tempReference = (new Reference(
            $middleField,
            Entity\ElementEntityStrategy::getEntityName($iblockId),
            Join::on('this.ELEMENT_ID', 'ref.ID')
        ))->configureJoinType($join);

        $references[] = new Model\TableReference('element', $code, $tempReference);

        return $references;
    }

    public function createFields(DTO\ReferenceDTO $dto): array
    {
        $fields = [];
        $code = $dto->getCode();
        $type = $dto->getType();
        $fields[] = sprintf('ELEMENT.%s', $code);

        return $fields;
    }

    public function createFilterFields(DTO\ReferenceDTO $dto): array
    {
        $fields = [];
        $code = $dto->getCode();
        $value = $dto->getValue();

        $fields[sprintf('ELEMENT.%s', $code)] = $value;

        return $fields;
    }
}
