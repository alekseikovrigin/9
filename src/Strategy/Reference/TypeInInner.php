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

class TypeInInner extends AbstractTypeReferenceStrategy implements ReferenceStrategy
{
    private $prefix = "~";
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
            $this->prefix . $code,
            Service\ReferenceManager::getReferenceClass($type),
            Join::on("this.$code", 'ref.ID')
        ));
        $references[] = new Model\TableReference('inner', $code, $tempReference);

        return $references;
    }

    public function createFields(DTO\ReferenceDTO $dto): array
    {
        $fields = [];
        $code = $this->prefix . $dto->getCode();
        $type = $dto->getType();

        if($type == 'E'){
            $fields[] = sprintf('%s.ID', $code);
            $fields[] = sprintf('%s.NAME', $code);
        }elseif($type == 'F'){
            $fields[] = sprintf('%s.ID', $code);
            $fields[] = sprintf('%s.FILE_NAME', $code);
        }elseif($type == 'L') {
            $fields[] = sprintf('%s.ID', $code);
            $fields[] = sprintf('%s.XML_ID', $code);
            $fields[] = sprintf('%s.VALUE', $code);
        }

        return $fields;
    }
}
