<?php
namespace alekseikovrigin\qubixqueries\Model;

class Element {
    private $id;
    private $idField;
    private $properties = [];

    public function __construct($id) {
        $this->id = $id;
    }

    public function collectValues()
    {
        return $this->properties;
    }

    public function addProperty($name, $name2, $value)
    {
        if (isset($this->properties[$name])) {
            $property = $this->properties[$name];
            $currentProperties = $property->getAll();
            $currentProperties[($name2 ?: "Value")] = $value;
            $property->setAll($currentProperties);
        } else {
            $this->properties[$name] = new Property(
                [
                    ($name2 ?: "Value") => $value
                ]
            );
        }
    }

    public function addMultipleProperty($name, $name2, $value)
    {
        if (!isset($this->properties[$name])) {
            $this->properties[$name] = new Property([]);
        }

        $allProperties = $this->properties[$name]->getAll();

        if (empty($allProperties)){
            $idField = $name2;
        }else{
            $lastIndex = key($allProperties);
            $idField = $allProperties[$lastIndex]->idField;
        }

        if (!isset($allProperties[$value]) || $name2 !== $idField) {
            if ($name2 === $idField) {
                $allProperties[$value] = new Element($value);
                $allProperties[$value]->idField = $name2;
                $allProperties[$value]->properties[$name2] = $value;
            } else {
                end($allProperties);
                $lastIndex = key($allProperties);
                if($lastIndex !== null) {
                    $allProperties[$lastIndex]->properties[$name2] = $value;
                }
            }
        }

        $this->properties[$name]->setAll($allProperties);
    }

    public function __call($name, $arguments) {
        $propertyName = ucfirst(str_replace('get', '', $name));
        if (isset($this->properties[$propertyName])) {
            return $this->properties[$propertyName];
        }
        return null;
    }

    public function getMultipleProperty($name) {
        return isset($this->properties[$name]) ? $this->properties[$name] : null;
    }
}