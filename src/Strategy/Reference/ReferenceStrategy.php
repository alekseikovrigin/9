<?php
namespace alekseikovrigin\qubixqueries\Strategy\Reference;

use alekseikovrigin\qubixqueries\DTO;

interface ReferenceStrategy {
    public function createReference(DTO\ReferenceDTO $dto);
}