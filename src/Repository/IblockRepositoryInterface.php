<?php
namespace alekseikovrigin\qubixqueries\Repository;

interface IblockRepositoryInterface
{
    public function getProperties(array $params): array;
    public function getIblockId(string $iblockApiCode): array;
}