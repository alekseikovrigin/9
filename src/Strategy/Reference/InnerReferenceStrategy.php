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

class InnerReferenceStrategy extends AbstractReferenceStrategy implements ReferenceStrategy
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

    public function createFilterFields(DTO\ReferenceDTO $dto): array
    {
        $fields = [];
        $code = $dto->getCode();
        $value = $dto->getValue();

        $fields[sprintf('%s', $code)] = $value;

        return $fields;
    }
}
