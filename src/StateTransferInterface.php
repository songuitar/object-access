<?php

namespace Songuitar\ObjectAccess;


interface StateTransferInterface
{
    /**
     * @param object $from
     * @param object $to
     */
    public function transfer($from, $to): void;

    /**
     * @return array
     */
    public function getExcludeFields(): array;

    /**
     * @param array $excludeFields
     * @return mixed
     */
    public function setExcludeFields(array $excludeFields);

    /**
     * @return array
     */
    public function getIncludeFields(): array;

    /**
     * @param array $excludeFields
     * @return mixed
     */
    public function setIncludeFields(array $excludeFields);
}