<?php

namespace alekseikovrigin\qubixqueries\Service;

use  alekseikovrigin\qubixqueries\Strategy\Reference;

class ReferenceFactory
{
    public static function createReferenceStrategy($code, $type, $multiple, $table, $mainTable): Reference\ReferenceStrategy
    {
        if ($table == "facetInner") {
            if (in_array($type, ['E', 'F', 'L'])) {
                return new Reference\TypeInFacet();
            } else {
                return new Reference\FacetValue();
            }
        } elseif ($table == "facet") {
            if (in_array($type, ['E', 'F', 'L'])) {
                return new Reference\FacetReferenceStrategy();
            } else {
                return new Reference\FacetAndFacetValue();
            }
        } elseif ($table == "element") {
            if (in_array($type, ['E', 'F', 'L'])) {
                return new Reference\TypeInElement();
            } else {
                return new Reference\ElementReferenceStrategy();
            }
        } elseif ($table == "inner") {
            if (in_array($type, ['E', 'F', 'L'])) {
                return new Reference\TypeInInner();
            } else {
                return new Reference\InnerReferenceStrategy();
            }
        } elseif ($table == "single") {
            if (in_array($type, ['E', 'F', 'L'])) {
                return new Reference\TypeInSingle();
            } else {
                return new Reference\SingleReferenceStrategy();
            }
        } elseif ($table == "subquery") {
            return new Reference\SubQueryReferenceStrategy();
        } else {
            if (in_array($type, ['E', 'F', 'L'])) {
                return new Reference\TypeInMultiple();
            } else {
                return new Reference\MultipleReferenceStrategy();
            }
        }
    }
}

