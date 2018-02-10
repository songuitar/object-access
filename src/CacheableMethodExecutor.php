<?php

namespace Songuitar\ObjectAccess;

use Psr\Cache\CacheItemPoolInterface;

class CacheableMethodExecutor implements CacheableMethodExecutorInterface
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cacheItemPool;

    /**
     * CacheableMethodExecutor constructor.
     * @param CacheItemPoolInterface $cacheItemPool
     */
    public function __construct(CacheItemPoolInterface $cacheItemPool)
    {
        $this->cacheItemPool = $cacheItemPool;
    }

    /**
     * @param object $object
     * @param string $method
     * @param array $args
     * @param \Closure $keyGenerator
     * @return mixed
     */
    public function getCachedMethodResult($object, string $method, array $args, \Closure $keyGenerator)
    {
        $key = call_user_func_array($keyGenerator, $args);

        $item = $this->cacheItemPool->getItem($key);

        if (!$item->isHit()) {
            //TODO: serialize reflection objects specific way
            $value = call_user_func_array([$object, $method], $args);
            $item->set($value);
            $this->cacheItemPool->save($item);
        }

        return $item->get();
    }
}