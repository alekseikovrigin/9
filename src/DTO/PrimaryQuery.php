<?php

namespace alekseikovrigin\qubixqueries\DTO;

class PrimaryQuery
{
    public $allRuntimeFields;
    public $filterRuntimeFields;
    public $table;
    public $cacheJoins;
    public $cacheTtl;

    public function __construct($allRuntimeFields, $filterRuntimeFields, $table, $cacheJoins, $cacheTtl)
    {
        $this->allRuntimeFields = $allRuntimeFields;
        $this->filterRuntimeFields = $filterRuntimeFields;
        $this->table = $table;
        $this->cacheJoins = $cacheJoins;
        $this->cacheTtl = $cacheTtl;
    }

}