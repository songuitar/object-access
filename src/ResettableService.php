<?php

namespace Songuitar\Common;

/**
 * Class ResettableService.
 */
abstract class ResettableService
{
    /**
     * @var array
     */
    private $_defaultState = [];

    /**
     * ResettableService constructor.
     * Writes object state in a variable.
     *
     * Method should be called in child constructor after setting all dependencies
     *
     * @throws \LogicException
     */
    public function __construct()
    {
        $reflection = new \ReflectionClass($this);
        if (self::class !== $reflection->getParentClass()->getName()) {
            throw new \LogicException('resettable service should not be nested');
        }
        foreach ($reflection->getProperties() as $reflectionProperty) {
            $reflectionProperty->setAccessible(true);
            $this->_defaultState[$reflectionProperty->getName()] = $reflectionProperty->getValue($this);
        }
    }

    /**
     * Method is declared as protected to prevent incorrect usage of resettable feature.
     */
    protected function __reset(): void
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getProperties() as $reflectionProperty) {
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($this, $this->_defaultState[$reflectionProperty->getName()]);
        }
    }
}
