<?php

namespace Songuitar\ObjectAccess;


interface ReflectionExtractorInterface
{
    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return \ReflectionProperty[]
     */
    public function extractReflectionProperties(\ReflectionClass $reflectionClass): array;

    /**
     * @param $object
     * @param string $propertyName
     * @return \ReflectionProperty
     */
    public function getReflectionProperty($object, string $propertyName): \ReflectionProperty;
}