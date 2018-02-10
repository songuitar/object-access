<?php

namespace Songuitar\ObjectAccess\Test;

use PHPUnit\Framework\TestCase;
use Songuitar\ObjectAccess\ReflectionAccessor;
use Songuitar\ObjectAccess\ReflectionExtractor;
use Songuitar\ObjectAccess\ReflectionExtractorCache;
use Songuitar\ObjectAccess\Test\Fixture\Entity;
use Songuitar\ObjectAccess\Test\Fixture\EntitySuperClass;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Simple\ArrayCache;

class ReflectionExtractorTest extends TestCase
{
    /**
     * @var ReflectionExtractor
     */
    private $reflectionExtractor;

    public function setUp()
    {
        parent::setUp();
        $this->reflectionExtractor = new ReflectionExtractor();
    }

    public function testGetReflectionProperty()
    {
        $entity = new Entity();

        $reflectionProperty = $this->reflectionExtractor->getReflectionProperty($entity, 'parentField');

        $this->assertEquals((new \ReflectionClass(EntitySuperClass::class))->getProperty('parentField'), $reflectionProperty);

        $reflectionProperty = $this->reflectionExtractor->getReflectionProperty($entity, 'field');

        $this->assertEquals((new \ReflectionClass(Entity::class))->getProperty('field'), $reflectionProperty);

        $this->expectException(\ReflectionException::class);

        $this->reflectionExtractor->getReflectionProperty($entity, 'nonExistingField');
    }


}