<?php
namespace alekseikovrigin\qubixqueries\Strategy\Reference;

use alekseikovrigin\qubixqueries\DTO;

abstract class AbstractTypeReferenceStrategy extends AbstractReferenceStrategy
{
    public function createFields(DTO\ReferenceDTO $dto): array
    {
        $fields = [];
        $code = $dto->getCode();
        $type = $dto->getType();
        $innerCode = $dto->getInnerCode();

        if ($innerCode){
            $fields[] = sprintf('%s.%s', $code, $innerCode);
        }elseif($type == 'E'){
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