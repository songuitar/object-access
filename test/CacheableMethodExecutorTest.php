<?php

namespace Songuitar\ObjectAccess\Test;


use PHPUnit\Framework\TestCase;
use Songuitar\ObjectAccess\CacheableMethodExecutor;
use Songuitar\ObjectAccess\CacheableMethodExecutorInterface;
use Songuitar\ObjectAccess\Test\Fixture\Entity;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class CacheableMethodExecutorTest extends TestCase
{
    /**
     * @var CacheableMethodExecutorInterface
     */
    private $methodExecutor;

    public function setUp()
    {
        parent::setUp();
        $this->methodExecutor = new CacheableMethodExecutor(new ArrayAdapter());
    }

    public function testIsCached()
    {
        $cachedService = new class
        {
            public $doSomethingCallsCount = 0;
            public $doSomethingWithReflectionCallsCount = 0;

            public function doSomething(string $argument): string
            {
                $this->doSomethingCallsCount++;
                return md5($argument);
            }

            public function doSomethingWithReflection(string $className): \ReflectionClass
            {
                $this->doSomethingWithReflectionCallsCount++;
                return new \ReflectionClass($className);
            }
        };
        $keyGenerator = function (string $argument) {
            return (string)crc32($argument);
        };

        $result = $this->methodExecutor->getCachedMethodResult($cachedService, 'doSomething', ['12345'], $keyGenerator);

        $this->assertEquals('827ccb0eea8a706c4c34a16891f84e7b', $result);

        $result = $this->methodExecutor->getCachedMethodResult($cachedService, 'doSomething', ['12345'], $keyGenerator);

        $this->assertEquals('827ccb0eea8a706c4c34a16891f84e7b', $result);

        $result = $this->methodExecutor->getCachedMethodResult($cachedService, 'doSomething', ['12346'], $keyGenerator);

        $this->assertEquals('a3590023df66ac92ae35e3316026d17d', $result);

        $this->assertEquals(2, $cachedService->doSomethingCallsCount);
    }

    public function testCacheReflectionClass()
    {
        $cachedService = new class
        {
            public $doSomethingWithReflectionCallsCount = 0;

            public function doSomethingWithReflection(string $className): \ReflectionProperty
            {
                $this->doSomethingWithReflectionCallsCount++;
                return new \ReflectionProperty($className, 'field');
            }
        };
        $keyGenerator = function (string $className) {
            return (string)crc32($className);
        };

        $result = $this->methodExecutor->getCachedMethodResult(
            $cachedService, 'doSomethingWithReflection', [Entity::class], $keyGenerator
        );

        $this->assertEquals(new \ReflectionProperty(Entity::class, 'field'), $result);

        $result = $this->methodExecutor->getCachedMethodResult(
            $cachedService, 'doSomethingWithReflection', [Entity::class], $keyGenerator
        );

        $this->assertEquals(new \ReflectionProperty(Entity::class, 'field'), $result);

        $this->assertEquals(1, $cachedService->doSomethingWithReflectionCallsCount);
    }

}