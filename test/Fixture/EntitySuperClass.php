<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 22.01.18
 * Time: 16:27
 */

namespace Songuitar\Common\Test\Fixture;


abstract class EntitySuperClass
{
    const DEFAULT_VALUE_PARENT_FIELD = '';

    /**
     * @var string
     */
    private $parentField = self::DEFAULT_VALUE_PARENT_FIELD;

    /**
     * @return string
     */
    public function getParentField(): string
    {
        return $this->parentField;
    }

    /**
     * @param string $parentField
     * @return EntitySuperClass
     */
    public function setParentField(string $parentField): EntitySuperClass
    {
        $this->parentField = $parentField;
        return $this;
    }
}