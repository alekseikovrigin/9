<?php
namespace alekseikovrigin\qubixqueries\Strategy\Entity;

use Bitrix\Main\Entity\Base;

abstract class AbstractEntityStrategy
{
    protected $iblockId;
    protected $fields;

    public function compileEntity(): Base
    {
        $entityName = static::getEntityName($this->iblockId)."Table";

        if (class_exists($entityName)) {
            return $entityName::getEntity();
        }

        return Base::compileEntity(
            static::getEntityName($this->iblockId),
            $this->multiplePropertiesTable($this->fields),
            ['table_name' => static::getTableName($this->iblockId)]
        );
    }
}