<?php

namespace alekseikovrigin\qubixqueries;

use Illuminate\Container\Container;
use alekseikovrigin\qubixqueries\Service\ReferenceManager;

class Query {

    protected $queryInstance;
    protected static $container;

    public function __construct(string $entityClass = null) {
        if (!self::$container) {
            $this->setupContainer();
        }
        $this->queryInstance = self::$container->make(QubixQuery::class, ['entityClass' => $entityClass]);
    }

    public static function getList(array $params, $entityClass = null) {
        if (!self::$container) {
            self::setupContainer();
        }

        $customQuery = self::$container->make(QubixQuery::class, ['entityClass' => $entityClass]);
        return $customQuery->putFromStatic($params);
    }

    private static function setupContainer() {
        self::$container = new Container;

        self::$container->bind(Repository\IblockRepository::class, function () {
            return new Repository\IblockRepository();
        });
        self::$container->bind(Repository\CachedIblockRepository::class, function ($container) {
            return new Repository\CachedIblockRepository($container->make(Repository\IblockRepository::class));
        });

        self::$container->bind(ReferenceManager::class);
        self::$container->singleton(QubixQuery::class, function ($container, $args) {
            $entityClass = $args['entityClass'] ?? null;
            return new QubixQuery($container->make(Repository\CachedIblockRepository::class), $container->make(ReferenceManager::class), $entityClass);
        });
    }

    public function __call($method, $parameters) {
        return $this->queryInstance->$method(...$parameters);
    }
}
