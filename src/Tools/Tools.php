<?php

namespace alekseikovrigin\qubixqueries\Tools;

class Tools
{
    public static function getPascalCase(string $string): string
    {
        return str_replace('_', '', ucwords(strtolower($string), '_'));
    }

    public static function getFieldMappings(array $fields): array
    {
        $mapping = [];
        foreach ($fields as $field) {
            $mapping[$field] = str_replace('.', '_', strtoupper($field));
        }
        return $mapping;
    }
}