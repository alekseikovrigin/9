<?php
namespace alekseikovrigin\qubixqueries\Service;

use alekseikovrigin\qubixqueries\Strategy\Entity;

class EntityStrategyFactory
{
    public static function getStrategy($type, $iblockId, $fields = null): Entity\EntityStrategy
    {
        switch ($type) {
            case 'single':
                return new Entity\SingleEntityStrategy($iblockId, $fields);
            case 'multiple':
                return new Entity\MultipleEntityStrategy($iblockId, $fields);
            case 'facet':
                return new Entity\FacetEntityStrategy($iblockId, $fields);
            case 'facetvalue':
                return new Entity\FacetValueEntityStrategy($iblockId, $fields);
            case 'element':
                return new Entity\ElementEntityStrategy($iblockId, $fields);
            case 'inner':
                return new Entity\ElementEntityStrategy($iblockId, $fields);
            case 'subquery':
                return new Entity\SubQueryEntityStrategy($iblockId, $fields);
            default:
                throw new Exception("Unknown strategy type: $type");
        }
    }
}
