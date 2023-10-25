<?php
namespace alekseikovrigin\qubixqueries\Model;

class TableReference {
    public $type;
    public $code;
    public $reference;

    public function __construct($type, $code, $reference) {
        $this->type = $type;
        $this->code = $code;
        $this->reference = $reference;
    }
}
