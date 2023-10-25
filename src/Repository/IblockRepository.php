<?php
namespace alekseikovrigin\qubixqueries\Repository;
use Bitrix\Main\Entity;

class IblockRepository implements IblockRepositoryInterface
{
    public function getProperties($params = array()): array
    {
        $arProps = array();
        $runtime = array(
            new Entity\ReferenceField(
                'SECTION_PROPERTY',
                '\Bitrix\Iblock\SectionPropertyTable',
                array('=this.ID' => 'ref.PROPERTY_ID'),
                array('join_type' => 'LEFT')
            )
        );

        $arProps = \Bitrix\Iblock\PropertyTable::getList(array(
            'select' => array(
                "ID", "IBLOCK_ID", "NAME", "CODE", "MULTIPLE", "USER_TYPE", "PROPERTY_TYPE",
                'SECTION_PROPERTY_SMART_FILTER' => 'SECTION_PROPERTY.SMART_FILTER'
            ),
            'filter' => $params,
            'runtime' => $runtime
        ))->fetchAll();

        return $arProps;
    }

    public function getIblockId(string $apiCode): array
    {
        return \Bitrix\Iblock\IblockTable::getList(
            ['filter' => array('API_CODE' => $apiCode)]
        )->fetch();
    }
}
