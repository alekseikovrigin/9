<?php
namespace alekseikovrigin\qubixqueries\Service;

use Bitrix\Main\ORM\Objectify\Collection;
use Bitrix\Main\ORM\Objectify\IdentityMap;
use Bitrix\Main\ORM\Query\Filter\ConditionTree;
use Bitrix\Main\ORM\Query\Query;

class QueryHelper
{
    public static function decompose(Query $query, $fairLimit = true, $separateRelations = true, $dto)
    {
        $start = microtime(true);
        $entity = $query->getEntity();
        $primaryNames = $entity->getPrimaryArray();
        $originalSelect = $query->getSelect();

        $allRuntimeFields = $dto->allRuntimeFields;
        $filterRuntimeFields = $dto->filterRuntimeFields;
        $table = $dto->table;
        $cacheJoins = $dto->cacheJoins;
        $cacheTtl = $dto->cacheTtl;

        if ($fairLimit)
        {
            $query->setSelect($entity->getPrimaryArray());
            $query->setDistinct();

            if($table == "facet") {
                 $query->addSelect(new \Bitrix\Main\Entity\ExpressionField('ID', '%s', 'ELEMENT_ID'));
            }

            foreach ($filterRuntimeFields as $field) {
                $query->registerRuntimeField($field);
            }

            $rows = $query->fetchAll();

            if (empty($rows))
            {
                return $query->getEntity()->createCollection();
            }

            $query = $entity->getDataClass()::query();
            $query->setSelect($originalSelect);
            $query->where(static::getPrimaryFilter($primaryNames, $rows));
        }

        if ($separateRelations)
        {
            $commonSelect = [];
            $dividedSelect = [];

            foreach ($originalSelect as $selectItem)
            {
                $selQuery = $entity->getDataClass()::query();
                $selQuery->addSelect($selectItem);

                foreach ($runtimeAll as $field) {
                    $selQuery->registerRuntimeField($field);
                }
                $selQuery->getQuery(true);

                foreach ($selQuery->getChains() as $chain)
                {
                    if ($chain->hasBackReference())
                    {
                        $dividedSelect[] = $selectItem;
                        continue 2;
                    }
                }

                $commonSelect[] = $selectItem;
            }

            if (empty($commonSelect))
            {
                $commonSelect = $query->getEntity()->getPrimaryArray();
            }

            $query->setSelect($commonSelect);
        }

        if($table == "facet") { //TODO
           //$query->setDistinct(true);
            $query->addSelect(new \Bitrix\Main\Entity\ExpressionField('ID', '%s', 'ELEMENT_ID'));
            $query->addFilter("SECTION_ID", 0);
            $query->addFilter("ELEMENT.IBLOCK_ID", 2);
        }else{
            $query->addSelect('ID');
            //$query->addFilter("IBLOCK_ID", 2);
        }

        foreach ($allRuntimeFields as $field) {
            $query->registerRuntimeField($field);
        }
        $query->cacheJoins($cacheJoins);
        $query->setCacheTtl($cacheTtl);
        $collection = $query->fetchAll();

        if (!empty($dividedSelect) && $collection->count())
        {
            $im = new IdentityMap;
            $primaryValues = [];

            foreach ($collection as $object)
            {
                $im->put($object);

                $primaryValues[] = $object->primary;
            }

            $primaryFilter = static::getPrimaryFilter($primaryNames, $primaryValues);

            foreach ($dividedSelect as $selectItem)
            {
                $result = $entity->getDataClass()::query()
                    ->addSelect($selectItem)
                    ->where($primaryFilter)
                    ->exec();

                $result->setIdentityMap($im);
                $result->fetchAll();
            }
        }
        i(round(microtime(true) - $start, 12));
        i("decompose");
        return $collection;
    }

    public static function getPrimaryFilter($primaryNames, $primaryValues)
    {
        $commonSubFilter = new ConditionTree();

        if (count($primaryNames) === 1)
        {
            $values = [];

            foreach ($primaryValues as $row)
            {
                $values[] = $row[$primaryNames[0]];
            }

            $commonSubFilter->whereIn($primaryNames[0], $values);
        }
        else
        {
            $commonSubFilter->logic('or');

            foreach ($primaryValues as $row)
            {
                $primarySubFilter = new ConditionTree();

                foreach ($primaryNames as $primaryName)
                {
                    $primarySubFilter->where($primaryName, $row[$primaryName]);
                }
                $commonSubFilter->where($primarySubFilter);
            }

        }

        return $commonSubFilter;
    }
}
