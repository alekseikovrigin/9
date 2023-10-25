<?php
namespace alekseikovrigin\qubixqueries\Service;

use alekseikovrigin\qubixqueries\DTO;

class ReferenceManager {
    private $references = [];
    private $strategy;

    public function addReference(DTO\ReferenceDTO $dto) {
        $this->strategy = ReferenceFactory::createReferenceStrategy($dto->getCode(), $dto->getType(), $dto->getMultiple(), $dto->getTable(), $dto->getMainTable());
        $references = $this->strategy->createReference($dto);

        return $references;
    }

    public function addOutFields(DTO\ReferenceDTO $dto) {
        $fields = $this->strategy->createFields($dto);

        return $fields;
    }

    public function addFilterFields(DTO\ReferenceDTO $dto) {
        $fields = $this->strategy->createFilterFields($dto);

        return $fields;
    }

    public function addColumn($id, $code, string $propertyType)
    {
        $class = self::getFieldClass($propertyType);
        return new $class(
            $code,
            array(
                'column_name' => 'PROPERTY_' . $id
            )
        );
    }

    static function getReferenceClass(string $propertyType)
    {
        if ($propertyType == 'E') {
            $tableClass = \Bitrix\Iblock\ElementTable::class;
        } elseif ($propertyType == 'F') {
            $tableClass = \Bitrix\Main\FileTable::class;
        } elseif ($propertyType == 'L') {
            $tableClass = \Bitrix\Iblock\PropertyEnumerationTable::class;
        }
        return $tableClass;
    }

    static function getFieldClass(string $propertyType)
    {
        if ($propertyType == 'S') {
            $tableClass = \Bitrix\Main\Entity\StringField::class;
        } elseif ($propertyType == 'N') {
            $tableClass = \Bitrix\Main\Entity\IntegerField::class;
        } elseif ($propertyType == 'E') {
            $tableClass = \Bitrix\Main\Entity\IntegerField::class;
        } else{
            $tableClass = \Bitrix\Main\Entity\IntegerField::class;
        }
        return $tableClass;
    }
}
