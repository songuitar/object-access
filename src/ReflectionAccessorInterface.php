<?php

namespace Songuitar\ObjectAccess;

/**
 * Interface ReflectionAccessorInterface
 * @package Songuitar\Denormalizer\Service
 *
 * Interface of simple accessor that can write in private properties without calling setters
 */
interface ReflectionAccessorInterface
{
    /**
     * @param object $object
     * @param string $propertyName
     * @return mixed
     */
    public function getValue($object, string $propertyName);

    /**
     * @param $object
     * @param string $propertyName
     * @param mixed $value
     * @return void
     */
    public function setValue($object, string $propertyName, $value): void;

}