<?php

namespace alekseikovrigin\qubixqueries;

use alekseikovrigin\qubixqueries\Tools\Tools;
use Bitrix\Main\ORM\Query\Query as QueryBitrix;

use alekseikovrigin\qubixqueries\Service\ReferenceManager;
use alekseikovrigin\qubixqueries\DTO\ReferenceDTO;
use alekseikovrigin\qubixqueries\Model\Element;

use alekseikovrigin\qubixqueries\Service\EntityStrategyFactory;
use alekseikovrigin\qubixqueries\Service\QueryHelper;

/**
 * @property $select
 * @property $filter
 * @method setSelect(string[] $arSelect)
 * @method query()
 */
class QubixQuery extends QueryBitrix
{

    private $arSelect;
    private $arFilter;
    private $columns = null;

    private $cache;
    private $referenceManager;
    private $entityClass;

    public $codes;
    private $iblockId;
    public $table;
    public $references = [];

    private $result;

    public function __construct(Repository\IblockRepositoryInterface $cache, ReferenceManager $referenceManager, $entityClass = null)
    {
        $this->cache = $cache;
        $this->referenceManager = $referenceManager;
        $this->entityClass = $entityClass;


        $this->filterHandler = static::filter();
        $this->whereHandler = static::filter();
        $this->havingHandler = static::filter();

    }

    public function putFromStatic(array $array): self
    {
        $this->select = $array["select"];
        $this->filter = $array["filter"];

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodes($iblockId): array
    {
        $codes = [];
        $arProps = $this->cache->getProperties(array('IBLOCK_ID' => $iblockId));

        foreach ($arProps as $prop) {
            $prop["TYPE"] = "property";
            $prop["PASCAL_CASE"] = Tools::getPascalCase($prop['CODE']);
            $codes[$prop['CODE']] = $prop;
        }

        $codes = array_merge($codes, Constants\DbFields::mainTablesFields());
        $this->codes = $codes;

        return $this->codes;
    }

    function init()
    {
        $this->arSelect = $this->select;
        $this->arFilter = $this->filter;
    }

    function addFieldsToEntity(array $resolverResults, string $typeFields): void
    {
        $codes = $this->codes;
        foreach (array_keys($resolverResults, $typeFields) as $prop) {
            if (array_key_exists($prop, $codes) && (!in_array($prop, $this->columns[$typeFields]))) {
                $id = $codes[$prop]['ID'];
                $code = $codes[$prop]['CODE'];
                $type = $codes[$prop]['PROPERTY_TYPE'];

                $this->columns[$typeFields][] = $this->referenceManager->addColumn($id, $code, $type);
            }
        }
    }

    function getRuntimeFields(array $fields, array $ref, string $mode = NULL): array
    {
        $codes = $this->codes;
        $iblockId = $this->iblockId;
        $filter = [];
        $runtimeFields = [];

        foreach ($fields as $key => $value) {
            if (is_string($key)) {
                $prop = $key;
            } else {
                $prop = $value;
            }
            $partsProp = explode('.', $prop);
            $firstPart = $partsProp["0"];
            $secondPart = $partsProp["1"];

            $join = "left";

            if (array_key_exists($firstPart, $codes)) {
                $id = $codes[$firstPart]['ID'];
                $type = $codes[$firstPart]['PROPERTY_TYPE'];
                $multiple = $codes[$firstPart]['MULTIPLE'];
                $code = $codes[$firstPart]['CODE'];
                $innerCode = $secondPart;

                $dto = new ReferenceDTO($id, $code, $innerCode, $type, $multiple, $iblockId, $ref[$code], $this->table, $join, $value);
                $references = $this->referenceManager->addReference($dto);
                if ($mode == "out") {
                    $filter = array_merge($filter, $this->referenceManager->addOutFields($dto));
                } else {
                    $filter = array_merge($filter, $this->referenceManager->addFilterFields($dto));
                }

                foreach ($references as $reference) {
                    $type = $reference->type;
                    $strategy = EntityStrategyFactory::getStrategy($type, $iblockId, $this->columns[$type]);
                    $strategy->compileEntity();
                    $runtimeFields[] = $reference->reference;
                }
            }
        }

        $result["filter"] = $filter;
        $result["runtimeFields"] = $runtimeFields;

        return $result;
    }


    function resolveTargetTable($fields, $useIndex)
    {
        $codes = $this->codes;
        $table = $this->table;
        $ref = array();


        foreach ($fields as $key => $value) {
            if (is_string($key)) {
                $prop0 = $key;
            } else {
                $prop0 = $value;
            }
            $prop = explode('.', $prop0)["0"];

            $ref["FACET_ID"] = "facet";
            $ref['ELEMENT_ID'] = "facet";

            if($codes[$prop]["TYPE"] != "property"){
                if ($table == "element") {
                    $ref[$prop] = "inner";
                }else{
                    $ref[$prop] = "element";
                }
            }elseif($codes[$prop]["SECTION_PROPERTY_SMART_FILTER"] == "Y" && $useIndex != "false") {
                if ($useIndex == "inner") {
                    $ref[$prop] = "facetInner";
                } else {
                    $ref[$prop] = "facet";
                }
            }else{
                if ($codes[$prop]['MULTIPLE'] == "Y") {
                    $ref[$prop] = "multiple";
                } else {
                    $ref[$prop] = "single";
                }
            }
        }

        return $ref;
    }


    function getFields(): array
    {
        $runtime = array();

        $ref = $this->resolveTargetTable($this->arFilter, $this->useIndex);
        $this->addFieldsToEntity($ref, "single");

        $ref1 = $this->resolveTargetTable($this->arSelect, $this->useIndex2);
        $this->addFieldsToEntity($ref1, "single");

        $res = $this->getRuntimeFields($this->arFilter, $ref);
        $runtime['filterRuntimeFields'] = $res["runtimeFields"];
        $arFilterEnd = $res["filter"];

        $res = $this->getRuntimeFields($this->arSelect, $ref1, "out");
        $runtime['allRuntimeFields'] = $res["runtimeFields"];
        $arSelectEnd = $res["filter"];

        $runtime['filter'] = $arFilterEnd;
        $runtime['select'] = $arSelectEnd;
        $this->selectEnd = $arSelectEnd;

        return $runtime;
    }


    public function fetchCollection(): array
    {
        $result = [];
        $prefix = $this->baseTable->getPrefix();

        $fieldMappings = Tools::getFieldMappings($this->selectEnd);
        $pascalCase = Constants\DbFields::extendedTablesFields();

        $objRes = $this->result;

        foreach ($objRes as $elementData) {
            $elementId = $elementData["ID"] ?? null;
            if (!$elementId) {
                continue;
            }

            if (!isset($result[$elementId])) {
                $result[$elementId] = new Element($elementId);
            }

            foreach ($fieldMappings as $dotSeparated => $underscoreSeparated) {

                $field = $elementData[$prefix . $underscoreSeparated] ?? null;
                if (!$field) {
                    continue;
                }

                [$type, $property] = explode('.', $dotSeparated);
                $type = str_replace("~", "", $type);

                if (in_array($type, array("PROPERTY_S", "ELEMENT"))) {
                    $methodName = $this->codes[$property]["PASCAL_CASE"];
                    $propName = "";
                    $type = $property;
                } else {
                    $methodName = $this->codes[$type]["PASCAL_CASE"];
                    $propName = $pascalCase[$property]["PASCAL_CASE"];
                }

                if ($this->codes[$type]["MULTIPLE"] == 'N') {
                    $result[$elementId]->addProperty($methodName, $propName, $field);
                } else {
                    $result[$elementId]->addMultipleProperty($methodName, $propName, $field);
                }
            }

        }

        return array_values($result);
    }

    public function fetchAll(\Bitrix\Main\Text\Converter $converter = null): array
    {
        $result = [];
        foreach ($this->result as $element) {
            $result[] = $element;
        }

        return $result;
    }

    protected function resolveIblockId()
    {
        $parameter = $this->getFilter()["IBLOCK_ID"];
        if (is_int($parameter)){
            return $parameter;
        }elseif (preg_match('/Element([A-Z][a-zA-Z]*)Table/', $this->entityClass, $matches)) {
            return $this->cache->getIblockId($matches[1])["ID"];
        }else{
            throw new \Exception('Iblock id needed');
        }
    }

    public function exec()
    {

//        $this->table = "element";
//        $this->useIndex = "false";
//        $this->useIndex2 = "false";
        $this->table = "facet";
        $this->useIndex = "false1";
        $this->useIndex2 = "inner";
        $this->iblockId = $this->resolveIblockId();

        $this->init();
        $this->codes = $this->getCodes($this->iblockId);

        $this->baseTable = EntityStrategyFactory::getStrategy($this->table, $this->iblockId, null);
        $ent = $this->baseTable->compileEntity();

        $runtime = $this->getFields();
        $query = (new QueryBitrix($ent));

        $query->setSelect($runtime['select'] ?? []);
        $query->setFilter($runtime['filter'] ?? []);
        $query->setCacheTtl($this->cacheTtl);
        $query->cacheJoins($this->cacheJoins);
        $query->setLimit($this->getLimit());

        $dto = new DTO\PrimaryQuery(
            $runtime['allRuntimeFields'],
            $runtime['filterRuntimeFields'],
            $this->table,
            $this->cacheJoins,
            $this->cacheTtl
        );
        $el_res = QueryHelper::decompose($query, true, false, $dto);

        $this->result = $el_res;

        return $this;
    }


}

