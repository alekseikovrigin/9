<?php

namespace alekseikovrigin\qubixqueries\Repository;

use CPHPCache;

class CachedIblockRepository implements IblockRepositoryInterface
{
    /**
     * @var IblockRepositoryInterface
     */
    private $receiver;
    private $cache;
    private $cacheTime;
    private $cachePath;

    public function __construct(IblockRepositoryInterface $receiver)
    {
        $this->receiver = $receiver;
        $this->cache = new CPHPCache();
        $this->cacheTime = 3600;
        $this->cachePath = "/qubixqueries";
    }

    public function getProperties(array $params): array
    {
        $cacheId = md5('getIblockProperties' . $params["iblockId"]);

        if ($this->cache->InitCache($this->cacheTime, $cacheId, $this->cachePath)) {
            return $this->cache->GetVars();
        } elseif ($this->cache->StartDataCache()) {
            $result = $this->receiver->getProperties($params);
            $this->cache->EndDataCache($result);
            return $result;
        }
        return [];
    }

    public function getIblockId(string $iblockApiCode): array
    {
        $cacheId = md5('getIblockId' . $iblockApiCode);

        if ($this->cache->InitCache($this->cacheTime, $cacheId, $this->cachePath)) {
            return $this->cache->GetVars();
        } elseif ($this->cache->StartDataCache()) {
            $result = $this->receiver->getIblockId($iblockApiCode);
            $this->cache->EndDataCache($result);
            return $result;
        }
        return [];
    }
}
