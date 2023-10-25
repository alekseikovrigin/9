<?php
namespace alekseikovrigin\qubixqueries\Strategy\Entity;

use Bitrix\Main\ORM\Fields;
use Bitrix\Main\Entity\Base;

class FacetValueEntityStrategy extends AbstractEntityStrategy implements EntityStrategy {
    protected $fields;
    protected $iblockId;

    public function __construct(int $iblockId, $fields = null)
    {
        $this->iblockId = $iblockId;
        $this->fields = $fields;
    }

    public static function getEntityName(int $iblockId): string
    {
        return sprintf('facetvalue%s', $iblockId);
    }

    public static function getTableName(int $iblockId): string
    {
        return sprintf('b_iblock_%s_index_val', $iblockId);
    }

    public function multiplePropertiesTable($fields): array
    {
        return [
            new Fields\IntegerField('ID', ['primary' => true]),
            new Fields\StringField('VALUE', []),
        ];
    }
}