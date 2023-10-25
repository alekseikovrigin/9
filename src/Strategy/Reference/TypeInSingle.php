<?php

namespace alekseikovrigin\qubixqueries\Strategy\Reference;

use alekseikovrigin\qubixqueries\DTO;
use alekseikovrigin\qubixqueries\DTO\ReferenceDTO;
use alekseikovrigin\qubixqueries\Model\TableReference;
use alekseikovrigin\qubixqueries\Strategy\Entity;
use alekseikovrigin\qubixqueries\Model;
use alekseikovrigin\qubixqueries\Service;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class TypeInSingle extends AbstractTypeReferenceStrategy implements ReferenceStrategy
{
    /**
     * @param ReferenceDTO $dto
     * @return TableReference[]
     */
    public function createReference(DTO\ReferenceDTO $dto): array
    {
        $code = $dto->getCode();
        $type = $dto->getType();
        $iblockId = $dto->getIblockId();
        $join = $dto->getJoin();

        $references = [];

        $middleField = 'PROPERTY_S';

        $tempReference = (new Reference(
            $middleField,
            Entity\SingleEntityStrategy::getEntityName($iblockId),
            Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
        ));
        $references[] = new Model\TableReference('single', $middleField, $tempReference);

        $tempReference = (new Reference(
            $code,
            Service\ReferenceManager::getReferenceClass($type),
            Join::on("this.$middleField.$code", 'ref.ID')
        ));
        $references[] = new Model\TableReference('single', $code, $tempReference);

        return $references;
    }
}
