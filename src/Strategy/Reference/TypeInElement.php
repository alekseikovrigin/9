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

class TypeInElement extends AbstractTypeReferenceStrategy implements ReferenceStrategy
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

        $middleField = "ELEMENT";
        $tempReference = (new Reference(
            $middleField,
            Entity\ElementEntityStrategy::getEntityName($iblockId),
            Join::on('this.ELEMENT_ID', 'ref.ID')
        ))->configureJoinType($join);
        $references[] = new Model\TableReference('element', $code, $tempReference);

        $tempReference = (new Reference(
            $code,
            Service\ReferenceManager::getReferenceClass($type),
            Join::on("this.$middleField.$code", 'ref.ID')
        ));
        $references[] = new Model\TableReference('element', $code, $tempReference);

        return $references;
    }
}
