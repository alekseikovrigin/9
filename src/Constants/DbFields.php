<?php

namespace alekseikovrigin\qubixqueries\Constants;

class DbFields
{
    public static function extendedTablesFields(): array
    {
        return [
            'ID' => [
                'PASCAL_CASE' => 'Id'
            ],
            'VALUE' => [
                'PASCAL_CASE' => 'Value'
            ],
            'NAME' => [
                'PASCAL_CASE' => 'Name'
            ],
            'FILE_NAME' => [
                'PASCAL_CASE' => 'FileName'
            ],
            'XML_ID' => [
                'PASCAL_CASE' => 'XmlId'
            ],
            'CODE' => [
                'PASCAL_CASE' => 'Code'
            ],
        ];
    }

    public static function mainTablesFields(): array
    {
        return [
            'ID' => [
                'CODE' => 'ID',
                'MULTIPLE' => 'N',
                'PROPERTY_TYPE' => 'N1',
                'PASCAL_CASE' => 'Id'
            ],
            'FACET_ID' => [
                'CODE' => 'FACET_ID',
                'MULTIPLE' => 'N',
                'PROPERTY_TYPE' => 'N',
                'PASCAL_CASE' => 'FacetId'
            ],
            'ELEMENT_ID' => [
                'CODE' => 'ELEMENT_ID',
                'MULTIPLE' => 'N',
                'PROPERTY_TYPE' => 'N',
                'PASCAL_CASE' => 'ElementId'
            ],
            'VALUE' => [
                'CODE' => 'VALUE',
                'MULTIPLE' => 'N',
                'PROPERTY_TYPE' => 'N',
                'PASCAL_CASE' => 'Value'
            ],
            'NAME' => [
                'CODE' => 'NAME',
                'MULTIPLE' => 'N',
                'PROPERTY_TYPE' => 'S',
                'PASCAL_CASE' => 'Name'
            ],
            'DETAIL_PICTURE' => [
                'CODE' => 'DETAIL_PICTURE',
                'MULTIPLE' => 'N',
                'PROPERTY_TYPE' => 'F',
                'PASCAL_CASE' => 'DetailPicture'
            ],
            'IBLOCK_ID' => [
                'CODE' => 'IBLOCK_ID',
                'MULTIPLE' => 'N',
                'PROPERTY_TYPE' => 'N1',
                'PASCAL_CASE' => 'IblockId'
            ]
        ];
    }


}