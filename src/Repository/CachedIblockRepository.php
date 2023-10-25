<?php

namespace alekseikovrigin\qubixqueries\Repository;

use \Bitrix\Main\Data\Cache;
use \Bitrix\Main\Application;
use \Bitrix\Main\Diag;

class CachedIblockRepository implements IblockRepositoryInterface
{
    /**
     * @var IReceivable
     */
    private $receiver;



    public function __construct(IblockRepositoryInterface $receiver)
    {
        $this->receiver = $receiver;
        $this->cache = new \CPHPCache();
        $this->cacheTime = 3600;
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

    public function getIblockId(string $apiCode): array
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
