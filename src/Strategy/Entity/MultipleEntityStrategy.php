<?php
namespace alekseikovrigin\qubixqueries\Strategy\Entity;

use Bitrix\Main\ORM\Fields;
use Bitrix\Main\Entity\Base;

class MultipleEntityStrategy extends AbstractEntityStrategy implements EntityStrategy {
    protected $fields;
    protected $iblockId;

    public function __construct($iblockId, $fields = null) {
        $this->iblockId = $iblockId;
        $this->fields = $fields;
    }

    public static function getEntityName(int $iblockId): string {
        return sprintf('PROPS_MULTI_%s', $iblockId);
    }

    public static function getTableName(int $iblockId): string {
        return sprintf('b_iblock_element_prop_m%s', $iblockId);
    }

    public function multiplePropertiesTable($fields): array {
        return [
            new Fields\IntegerField('ID', ['primary' => true, 'autocomplete' => true]),
            new Fields\IntegerField('IBLOCK_ELEMENT_ID', ['required' => true]),
            new Fields\IntegerField('IBLOCK_PROPERTY_ID', ['required' => true]),
            new Fields\TextField('VALUE', ['required' => true]),
            new Fields\IntegerField('VALUE_ENUM', []),
            new Fields\FloatField('VALUE_NUM', []),
            new Fields\StringField('DESCRIPTION', []),
        ];
    }
}

