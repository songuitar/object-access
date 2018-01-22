<?php

namespace Songuitar\Common\Test\Fixture;

class Entity extends EntitySuperClass
{
    const DEFAULT_VALUE_FIELD = 1;

    /**
     * @var int
     */
    private $field = self::DEFAULT_VALUE_FIELD;

    /**
     * @return int
     */
    public function getField(): int
    {
        return $this->field;
    }

    /**
     * @param int $field
     * @return Entity
     */
    public function setField(int $field): Entity
    {
        $this->field = $field;
        return $this;
    }
}