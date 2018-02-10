<?php

namespace Songuitar\ObjectAccess\Test;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Songuitar\ObjectAccess\CacheableMethodExecutor;
use Songuitar\ObjectAccess\ReflectionAccessor;
use Songuitar\ObjectAccess\ReflectionAccessorInterface;
use Songuitar\ObjectAccess\ReflectionExtractor;
use Songuitar\ObjectAccess\ReflectionExtractorCache;
use Songuitar\ObjectAccess\Test\Fixture\Entity;
use Songuitar\ObjectAccess\Test\Fixture\EntitySuperClass;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Simple\ArrayCache;

class ReflectionAccessorCacheTest extends TestCase
{
    /**
     * @var ReflectionAccessorInterface
     */
    private $accessor;

    /**
     * @var CacheItemPoolInterface
     */
    private $cachePool;

    public function setUp()
    {
        parent::setUp();
        $this->cachePool = new ArrayAdapter(0, false);
        $this->accessor = new ReflectionAccessor(new ReflectionExtractorCache(new CacheableMethodExecutor($this->cachePool)));
    }

    public function testReadValue()
    {
        $entity = new Entity();

        $value = $this->accessor->getValue($entity, 'parentField');

        $this->assertEquals(EntitySuperClass::DEFAULT_VALUE_PARENT_FIELD, $value);

        $value = $this->accessor->getValue($entity, 'field');

        $this->assertEquals(Entity::DEFAULT_VALUE_FIELD, $value);

        $this->expectException(\ReflectionException::class);

        $this->accessor->getValue($entity, 'nonExistingField');
    }
}