<?php
namespace alekseikovrigin\qubixqueries\Strategy\Entity;

use Bitrix\Main\Entity;
use Bitrix\Main\Entity\Base;

class SingleEntityStrategy extends AbstractEntityStrategy implements EntityStrategy {
    protected $fields;
    protected $iblockId;

    public function __construct(int $iblockId, $fields = null) {
        $this->iblockId = $iblockId;
        $this->fields = $fields;
    }

    public static function getEntityName(int $iblockId): string {
        return sprintf('PROPS_SINGLE_%s', $iblockId);
    }

    public static function getTableName(int $iblockId): string {
        return sprintf('b_iblock_element_prop_s%s', $iblockId);
    }

    public function multiplePropertiesTable($fields): array {
        $primaryField = new Entity\IntegerField('IBLOCK_ELEMENT_ID', array(
            'primary' => true
        ));
        array_unshift($fields, $primaryField);

        return $fields;
    }
}