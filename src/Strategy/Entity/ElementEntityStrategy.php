<?php
namespace alekseikovrigin\qubixqueries\Strategy\Entity;

use Bitrix\Main\ORM\Fields;
use Bitrix\Main\Entity\Base;

class ElementEntityStrategy extends AbstractEntityStrategy implements EntityStrategy {
    protected $fields;
    protected $iblockId;

    public function __construct($iblockId, $fields = null)
    {
        $this->iblockId = $iblockId;
        $this->fields = $fields;
    }

    public static function getEntityName(int $iblockId): string
    {
        return "element";
    }

    public static function getTableName(int $iblockId): string
    {
        return 'b_iblock_element';
    }

    public function getPrefix(): string
    {
        return strtoupper(self::getEntityName($this->iblockId))."_";
    }

    public function multiplePropertiesTable($fields): array {
        return [
            new Fields\IntegerField('ID', ['primary' => true, 'autocomplete' => true]),
            new Fields\StringField('NAME', []),
            new Fields\StringField('CODE', []),
            new Fields\TextField('PREVIEW_TEXT', []),
            new Fields\TextField('DETAIL_TEXT', []),
            new Fields\IntegerField('PREVIEW_PICTURE', []),
            new Fields\IntegerField('DETAIL_PICTURE', []),
            new Fields\IntegerField('IBLOCK_ID', []),
        ];
    }
}

