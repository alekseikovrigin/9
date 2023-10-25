<?php
namespace alekseikovrigin\qubixqueries\Repository;

interface IblockRepositoryInterface
{
    public function getProperties(array $params): array;
    public function getIblockId(string $apiCode): array;
}