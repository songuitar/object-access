<?php

namespace Songuitar\ObjectAccess;


class ReflectionAccessor implements ReflectionAccessorInterface
{
    /**
     * @var ReflectionExtractorInterface
     */
    private $reflectionExtractor;

    /**
     * ReflectionAccessor constructor.
     * @param ReflectionExtractorInterface $reflectionExtractor
     */
    public function __construct(ReflectionExtractorInterface $reflectionExtractor)
    {
        $this->reflectionExtractor = $reflectionExtractor;
    }

    /**
     * @param object $object
     * @param string $propertyName
     * @return mixed
     */
    public function getValue($object, string $propertyName)
    {
        return $this->reflectionExtractor->getReflectionProperty($object, $propertyName)->getValue($object);
    }

    /**
     * @param object $object
     * @param string $propertyName
     * @param mixed $value
     * @return void
     */
    public function setValue($object, string $propertyName, $value): void
    {
        $this->reflectionExtractor->getReflectionProperty($object, $propertyName)->setValue($object, $value);
    }

}