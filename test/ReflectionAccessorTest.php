<?php

namespace Songuitar\ObjectAccess\Test;

use PHPUnit\Framework\TestCase;
use Songuitar\ObjectAccess\ReflectionAccessor;
use Songuitar\ObjectAccess\Test\Fixture\Entity;
use Songuitar\ObjectAccess\Test\Fixture\EntitySuperClass;

class ReflectionAccessorTest extends TestCase
{
    /**
     * @var ReflectionAccessor
     */
    private $accessor;

    public function setUp()
    {
        parent::setUp();
        $this->accessor = new ReflectionAccessor();
    }

    public function testGetReflectionProperty()
    {
        $entity = new Entity();

        $reflectionProperty = $this->accessor->getReflectionProperty($entity, 'parentField');

        $this->assertEquals((new \ReflectionClass(EntitySuperClass::class))->getProperty('parentField'), $reflectionProperty);

        $reflectionProperty = $this->accessor->getReflectionProperty($entity, 'field');

        $this->assertEquals((new \ReflectionClass(Entity::class))->getProperty('field'), $reflectionProperty);

        $this->expectException(\ReflectionException::class);

        $this->accessor->getReflectionProperty($entity, 'nonExistingField');
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