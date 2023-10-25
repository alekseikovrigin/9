<?php

namespace alekseikovrigin\bxfullquery\tests;
//require 'bitrix/modules/main/include/prolog_before.php';
define("NOT_CHECK_PERMISSIONS", true);
define("NO_AGENT_CHECK", true);

$_SERVER["DOCUMENT_ROOT"] = __DIR__ . '/../../../../../';

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


use alekseikovrigin\bxfullquery\Service\EntityStrategyFactory;
use PHPUnit\Framework\TestCase;
use alekseikovrigin\bxfullquery\QubixQuery;
use alekseikovrigin\bxfullquery\Service\ReferenceManager;

class FetchCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function it_correctly_processes_input_data()
    {

        $manager = new ReferenceManager();
        $testObject = new QubixQuery($manager);
        $testObject->baseTable = EntityStrategyFactory::getStrategy("facet", 2, null);
        $testObject->selectEnd = [
            'ELEMENT.ID', '~DETAIL_PICTURE.ID', '~DETAIL_PICTURE.FILE_NAME',
            'PROPERTY_S.MANUFACTURER', 'PROPERTY_S.ARTNUMBER', 'RECZ.ID',
            'RECZ.NAME', 'RECOMMEND.ID', 'RECOMMEND.NAME'
        ];
        $testObject->codes = array (
            'TITLE' =>
                array (
                    'ID' => 2,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Заголовок окна браузера',
                    'CODE' => 'TITLE',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'S',
                ),
            'KEYWORDS' =>
                array (
                    'ID' => 3,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Ключевые слова',
                    'CODE' => 'KEYWORDS',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'S',
                ),
            'META_DESCRIPTION' =>
                array (
                    'ID' => 4,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Мета-описание',
                    'CODE' => 'META_DESCRIPTION',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'S',
                ),
            'BRAND_REF' =>
                array (
                    'ID' => 5,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Бренд',
                    'CODE' => 'BRAND_REF',
                    'MULTIPLE' => 'Y',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => 'directory',
                    'PROPERTY_TYPE' => 'S',
                ),
            'NEWPRODUCT' =>
                array (
                    'ID' => 6,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Новинка',
                    'CODE' => 'NEWPRODUCT',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'Y',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'L',
                ),
            'SALELEADER' =>
                array (
                    'ID' => 7,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Лидер продаж',
                    'CODE' => 'SALELEADER',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'Y',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'L',
                ),
            'SPECIALOFFER' =>
                array (
                    'ID' => 8,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Спецпредложение',
                    'CODE' => 'SPECIALOFFER',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'Y',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'L',
                ),
            'ARTNUMBER' =>
                array (
                    'ID' => 9,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Артикул',
                    'CODE' => 'ARTNUMBER',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'S',
                ),
            'MANUFACTURER' =>
                array (
                    'ID' => 10,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Производитель',
                    'CODE' => 'MANUFACTURER',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'S',
                ),
            'MATERIAL' =>
                array (
                    'ID' => 11,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Материал',
                    'CODE' => 'MATERIAL',
                    'MULTIPLE' => 'Y',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'S',
                ),
            'COLOR' =>
                array (
                    'ID' => 12,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Цвет',
                    'CODE' => 'COLOR',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'S',
                ),
            'MORE_PHOTO' =>
                array (
                    'ID' => 13,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Картинки галереи',
                    'CODE' => 'MORE_PHOTO',
                    'MULTIPLE' => 'Y',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'F',
                ),
            'RECOMMEND' =>
                array (
                    'ID' => 14,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'С этим товаром рекомендуем',
                    'CODE' => 'RECOMMEND',
                    'MULTIPLE' => 'Y',
                    'FILTRABLE' => 'Y',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'E',
                ),
            'BLOG_POST_ID' =>
                array (
                    'ID' => 15,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'ID поста блога для комментариев',
                    'CODE' => 'BLOG_POST_ID',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'N',
                ),
            'BLOG_COMMENTS_CNT' =>
                array (
                    'ID' => 16,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Количество комментариев',
                    'CODE' => 'BLOG_COMMENTS_CNT',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'N',
                ),
            'BACKGROUND_IMAGE' =>
                array (
                    'ID' => 17,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Фоновая картинка для шаблона',
                    'CODE' => 'BACKGROUND_IMAGE',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'F',
                ),
            'TREND' =>
                array (
                    'ID' => 18,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Тренды',
                    'CODE' => 'TREND',
                    'MULTIPLE' => 'Y',
                    'FILTRABLE' => 'Y',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'L',
                ),
            'RECZ' =>
                array (
                    'ID' => 44,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Рек',
                    'CODE' => 'RECZ',
                    'MULTIPLE' => 'Y',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'E',
                ),
            'BRAND_REF1' =>
                array (
                    'ID' => 45,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Бренд1',
                    'CODE' => 'BRAND_REF1',
                    'MULTIPLE' => 'N',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => 'directory',
                    'PROPERTY_TYPE' => 'S',
                ),
            'REC' =>
                array (
                    'ID' => 885,
                    'IBLOCK_ID' => 2,
                    'NAME' => 'Рек',
                    'CODE' => 'REC',
                    'MULTIPLE' => 'Y',
                    'FILTRABLE' => 'N',
                    'USER_TYPE' => NULL,
                    'PROPERTY_TYPE' => 'L',
                ),
            'ID' =>
                array (
                    'CODE' => 'ID',
                    'MULTIPLE' => 'N',
                    'PROPERTY_TYPE' => 'N',
                ),
            'FACET_ID' =>
                array (
                    'CODE' => 'FACET_ID',
                    'MULTIPLE' => 'N',
                    'PROPERTY_TYPE' => 'N',
                ),
            'ELEMENT_ID' =>
                array (
                    'CODE' => 'ELEMENT_ID',
                    'MULTIPLE' => 'N',
                    'PROPERTY_TYPE' => 'N',
                ),
            'VALUE' =>
                array (
                    'CODE' => 'VALUE',
                    'MULTIPLE' => 'N',
                    'PROPERTY_TYPE' => 'N',
                ),
            'NAME' =>
                array (
                    'CODE' => 'NAME',
                    'MULTIPLE' => 'N',
                    'PROPERTY_TYPE' => 'S',
                ),
            'DETAIL_PICTURE' =>
                array (
                    'CODE' => 'DETAIL_PICTURE',
                    'MULTIPLE' => 'N',
                    'PROPERTY_TYPE' => 'F',
                ),
        );

        $testObject->result = array
        (
            "0" => array
            (
                "FACET2_ELEMENT_ID" => 8,
                "FACET2_~DETAIL_PICTURE_ID" => 61,
                "FACET2_~DETAIL_PICTURE_FILE_NAME" => 'm0k4qnchaprggn45b2mq3998dof5yi2d.jpg',
                "FACET2_PROPERTY_S_MANUFACTURER" => 'Россия "Модница"',
                "FACET2_PROPERTY_S_ARTNUMBER" => '144-13-xx',
                "FACET2_RECZ_ID" => 11,
                "FACET2_RECZ_NAME" => 'Нижнее белье Морская Волна',
                "FACET2_RECOMMEND_ID" => 11,
                "FACET2_RECOMMEND_NAME" => 'Нижнее белье Морская Волна',
                "ID" => 8,
            ),

            "1" => array
            (
                "FACET2_ELEMENT_ID" => 8,
                "FACET2_~DETAIL_PICTURE_ID" => 61,
                "FACET2_~DETAIL_PICTURE_FILE_NAME" => 'm0k4qnchaprggn45b2mq3998dof5yi2d.jpg',
                "FACET2_PROPERTY_S_MANUFACTURER" => 'Россия "Модница"',
                "FACET2_PROPERTY_S_ARTNUMBER" => '144-13-xx',
                "FACET2_RECZ_ID" => 11,
                "FACET2_RECZ_NAME" => 'Нижнее белье Морская Волна',
                "FACET2_RECOMMEND_ID" => 12,
                "FACET2_RECOMMEND_NAME" => 'Нижнее белье Белая Свобода',
                "ID" => 8,
            )
        );


        $collection = $testObject->fetchCollection();


        $this->assertIsArray($collection);
        i($collection["0"]);

        $this->assertEquals(8, $collection[0]->getId()->getValue());
    }
}
