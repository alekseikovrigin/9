<?php
namespace alekseikovrigin\qubixqueries\Repository;

use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Entity;

class IblockRepository implements IblockRepositoryInterface
{
    public function getProperties(array $params): array
    {
        $runtime = array(
            new Entity\ReferenceField(
                'SECTION_PROPERTY',
                '\Bitrix\Iblock\SectionPropertyTable',
                array('=this.ID' => 'ref.PROPERTY_ID'),
                array('join_type' => 'LEFT')
            )
        );

        return PropertyTable::getList(array(
            'select' => array(
                "ID", "IBLOCK_ID", "NAME", "CODE", "MULTIPLE", "USER_TYPE", "PROPERTY_TYPE",
                'SECTION_PROPERTY_SMART_FILTER' => 'SECTION_PROPERTY.SMART_FILTER'
            ),
            'filter' => $params,
            'runtime' => $runtime
        ))->fetchAll();
    }

    public function getIblockId(string $iblockApiCode): array
    {
        return IblockTable::getList(
            ['filter' => array('API_CODE' => $iblockApiCode)]
        )->fetch();
    }
}
