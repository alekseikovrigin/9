<?php
namespace alekseikovrigin\qubixqueries\Strategy\Entity;

use Bitrix\Main\ORM\Fields;
use Bitrix\Main\Entity\Base;

class FacetEntityStrategy extends AbstractEntityStrategy implements EntityStrategy {
    protected $fields;
    protected $iblockId;

    public function __construct(int $iblockId, $fields = null)
    {
        $this->iblockId = $iblockId;
        $this->fields = $fields;
    }

    public static function getEntityName(int $iblockId): string
    {
        return sprintf('facet%s', $iblockId);
    }

    public static function getTableName(int $iblockId): string
    {
        return sprintf('b_iblock_%s_index', $iblockId);
    }

    public function getPrefix(): string
    {
        return strtoupper(self::getEntityName($this->iblockId))."_";
    }

    public function multiplePropertiesTable($fields): array
    {
        return [
            new Fields\IntegerField('SECTION_ID', ['primary1' => true]),
            new Fields\IntegerField('ELEMENT_ID', ['primary' => true]),
            new Fields\IntegerField('FACET_ID', ['primary1' => true]),
            new Fields\IntegerField('VALUE', ['primary1' => true]),
            new Fields\FloatField('VALUE_NUM', ['primary1' => true]),
            new Fields\StringField('INCLUDE_SUBSECTIONS', []),
        ];
    }
}