<?php

namespace Songuitar\ObjectAccess;

/**
 * Class StateTransfer.
 *
 * Copy variables state from one object to variables with same name in another object
 */
class StateTransfer extends ResettableService implements StateTransferInterface
{
    /**
     * @var string[]
     */
    private $excludeFields = [];

    /**
     * @var string[]
     */
    private $includeFields = [];

    /**
     * @var ReflectionExtractorInterface
     */
    private $reflectionExtractor;

    /**
     * StateTransfer constructor.
     * @param ReflectionExtractorInterface $reflectionAccessor
     */
    public function __construct(ReflectionExtractorInterface $reflectionAccessor)
    {
        $this->reflectionExtractor = $reflectionAccessor;
        parent::__construct();
    }

    /**
     * @param object $from
     * @param object $to
     *
     * @throws \InvalidArgumentException
     */
    public function transfer($from, $to): void
    {
        if (!\is_object($from) || !\is_object($to)) {
            throw new \InvalidArgumentException('can\'t operate non-object values');
        }

        $fromProperties = $this->reflectionExtractor->extractReflectionProperties(new \ReflectionClass($from));
        $toProperties = $this->reflectionExtractor->extractReflectionProperties(new \ReflectionClass($to));

        foreach ($fromProperties as $fromProperty) {
            if ($this->getIncludeFields() && !\in_array($fromProperty->getName(), $this->getIncludeFields(), true)) {
                continue;
            }
            if (\in_array($fromProperty->getName(), $this->getExcludeFields(), true)) {
                continue;
            }
            foreach ($toProperties as $toProperty) {
                if ($fromProperty->getName() === $toProperty->getName()) {
                    $fromProperty->setAccessible(true);
                    $toProperty->setAccessible(true);
                    $toProperty->setValue($to, $fromProperty->getValue($from));
                }
            }
        }
        $this->__reset();
    }


    /**
     * @return string[]
     */
    public function getExcludeFields(): array
    {
        return $this->excludeFields;
    }

    /**
     * @param string[] $excludeFields
     *
     * @return StateTransfer
     */
    public function setExcludeFields(array $excludeFields): self
    {
        $this->excludeFields = $excludeFields;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getIncludeFields(): array
    {
        return $this->includeFields;
    }

    /**
     * @param string[] $includeFields
     *
     * @return StateTransfer
     */
    public function setIncludeFields(array $includeFields): self
    {
        $this->includeFields = $includeFields;

        return $this;
    }
}
