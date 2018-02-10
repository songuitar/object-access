<?php

namespace Songuitar\ObjectAccess;

interface CacheableMethodExecutorInterface
{
    /**
     * @param $object
     * @param string $method
     * @param array $args
     * @param \Closure $keyGenerator
     * @return mixed
     */
    public function getCachedMethodResult($object, string $method, array $args, \Closure $keyGenerator);
}