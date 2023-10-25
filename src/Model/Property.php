<?php

namespace alekseikovrigin\qubixqueries\Model;

class Property {
    private $properties = [];

    public function __construct(array $properties) {
        $this->properties = $properties;
    }

    public function add(array $property) {
        $this->properties[] = $property;
    }

    public function setAll(array $properties) {
        $this->properties = $properties;
    }

    public function getAll(): array {
        return $this->properties;
    }

    public function __call($name, $arguments) {
        $propertyName = ucfirst(str_replace('get', '', $name));
        return $this->properties[$propertyName] ?? null;
    }
}