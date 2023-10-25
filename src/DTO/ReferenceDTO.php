<?php
namespace alekseikovrigin\qubixqueries\DTO;

class ReferenceDTO {
    private $id;
    private $code;
    private $innerCode;
    private $type;
    private $multiple;
    private $iblockId;
    private $table;
    private $mainTable;
    private $join;
    private $value;

    public function __construct($id, $code, $innerCode = NULL, $type, $multiple, $iblockId, $table, $mainTable, $join, $value = NULL) {
        $this->id = $id;
        $this->code = $code;
        $this->innerCode = $innerCode;
        $this->type = $type;
        $this->multiple = $multiple;
        $this->iblockId = $iblockId;
        $this->table = $table;
        $this->mainTable = $mainTable;
        $this->join = $join;
        $this->value = $value;

    }

    public function getId() {
        return $this->id;
    }

    public function getCode() {
        return $this->code;
    }

    public function getInnerCode() {
        return $this->innerCode;
    }

    public function getType() {
        return $this->type;
    }

    public function getMultiple() {
        return $this->multiple;
    }

    public function getIblockId() {
        return $this->iblockId;
    }

    public function getTable() {
        return $this->table;
    }

    public function getMainTable() {
        return $this->mainTable;
    }

    public function getJoin() {
        return $this->join;
    }

    public function getValue() {
        return $this->value;
    }
}
