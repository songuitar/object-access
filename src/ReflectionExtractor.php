<?php

namespace Songuitar\ObjectAccess;


class ReflectionExtractor implements ReflectionExtractorInterface
{

    /**
     * @param object $object
     * @param string $propertyName
     * @return \ReflectionProperty
     * @throws \ReflectionException
     */
    public function getReflectionProperty($object, string $propertyName): \ReflectionProperty
    {
        foreach ($this->extractReflectionProperties(new \ReflectionClass($object)) as $reflectionProperty) {
            if ($reflectionProperty->getName() === $propertyName) {
                $reflectionProperty->setAccessible(true);
                return $reflectionProperty;
            }
        }

        throw new \ReflectionException('no such property ' . $propertyName . ' in ' . get_class($object) . ' and it parent classes');
    }

    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return \ReflectionProperty[]
     */
    public function extractReflectionProperties(\ReflectionClass $reflectionClass): array
    {
        $properties = $reflectionClass->getProperties();
        if ($parentReflection = $reflectionClass->getParentClass()) {
            $properties = array_merge($properties, $this->extractReflectionProperties($parentReflection));
        }

        return $properties;
    }
}