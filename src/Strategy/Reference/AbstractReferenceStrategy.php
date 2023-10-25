<?php
namespace alekseikovrigin\qubixqueries\Strategy\Reference;

use alekseikovrigin\qubixqueries\DTO;

abstract class AbstractReferenceStrategy
{

    public function getDefaultValue($innerCode): string
    {
        switch($innerCode){
            case "L": $value = "VALUE"; break;
            case "S": $value = "VALUE"; break;
            case "N": $value = "VALUE"; break;
            case "E": $value = "NAME"; break;
            default: $value = "";
        }

        return $value;
   }

    public function createFilterFields(DTO\ReferenceDTO $dto): array
    {
        $fields = [];
        $code = $dto->getCode();
        $type = $dto->getType();
        $innerCode = $dto->getInnerCode() ?: self::getDefaultValue($type);
        $value = $dto->getValue();

        $fields[sprintf('%s.%s', $code, $innerCode)] = $value;

        return $fields;
    }
}