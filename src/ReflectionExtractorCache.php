<?php

namespace Songuitar\ObjectAccess;


class ReflectionExtractorCache extends ReflectionExtractor
{
    public const KEY_PREFIX = 'reflectionExtractor';

    /**
     * @var CacheableMethodExecutorInterface
     */
    private $cacheableMethodExecutor;

    /**
     * ReflectionExtractorCache constructor.
     * @param CacheableMethodExecutorInterface $cacheItemPool
     */
    public function __construct(
        CacheableMethodExecutorInterface $cacheItemPool
    )
    {
        $this->cacheableMethodExecutor = $cacheItemPool;
    }

    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return \ReflectionProperty[]
     */
    public function extractReflectionProperties(\ReflectionClass $reflectionClass): array
    {
        return $this->cacheableMethodExecutor->getCachedMethodResult(
            $this,
            parent::class . '::extractReflectionProperties',
            [$reflectionClass],
            function (\ReflectionClass $reflectionClass) {
                return self::KEY_PREFIX . '.' . md5($reflectionClass->getName());
            }
        );
    }

    /**
     * @param object $object
     * @param string $propertyName
     * @return \ReflectionProperty
     * @throws \ReflectionException
     */
    public function getReflectionProperty($object, string $propertyName): \ReflectionProperty
    {
        return $this->cacheableMethodExecutor->getCachedMethodResult(
            $this,
            parent::class . '::getReflectionProperty',
            [$object, $propertyName],
            function ($object, string $propertyName) {
                $reflectionClass = new \ReflectionClass($object);
                return self::KEY_PREFIX . '.' . md5($reflectionClass->getName() . '.' . $propertyName);
            }
        );
    }

}