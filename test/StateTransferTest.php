<?php

namespace Songuitar\ObjectAccess\Test;

use PHPUnit\Framework\TestCase;
use Songuitar\ObjectAccess\ReflectionAccessor;
use Songuitar\ObjectAccess\StateTransfer;

/**
 * @coversNothing
 */
class StateTransferTest extends TestCase
{
    /**
     * @return StateTransfer
     */
    private function getStateTransfer(): StateTransfer
    {
        return new StateTransfer(new ReflectionAccessor());
    }

    public function testIsTransferredSimpleCase()
    {
        $stateTransfer = $this->getStateTransfer();

        $objectFrom = new class()
        {
            public $prop1 = [];
            public $prop2 = '';
            public $prop3 = 0;
        };

        $objectTo = new class()
        {
            public $prop1;
            public $prop2;
            public $prop3 = 0;
        };

        $stateTransfer->transfer($objectFrom, $objectTo);

        $this->assertEquals($objectTo->prop1, $objectFrom->prop1);
        $this->assertEquals($objectTo->prop2, $objectFrom->prop2);
        $this->assertEquals($objectTo->prop3, $objectFrom->prop3);
    }

    public function testIsTransferredWithExclude()
    {
        $stateTransfer = $this->getStateTransfer();

        $objectFrom = new class()
        {
            public $prop1 = [];
            public $prop2 = '';
            public $prop3 = 0;
        };

        $objectTo = new class()
        {
            public $prop1;
            public $prop2;
            public $prop3 = 0;
        };

        $stateTransfer->setExcludeFields(['prop1']);
        $stateTransfer->transfer($objectFrom, $objectTo);

        $this->assertEquals(null, $objectTo->prop1);
        $this->assertEquals($objectTo->prop2, $objectFrom->prop2);
        $this->assertEquals($objectTo->prop3, $objectFrom->prop3);
    }

    public function testIsTransferredWithInclude()
    {
        $stateTransfer = $this->getStateTransfer();

        $objectFrom = new class()
        {
            public $prop1 = [];
            public $prop2 = '';
            public $prop3 = 0;
        };

        $objectTo = new class()
        {
            public $prop1;
            public $prop2;
            public $prop3 = 0;
        };

        $stateTransfer->setIncludeFields(['prop1']);
        $stateTransfer->transfer($objectFrom, $objectTo);

        $this->assertEquals($objectFrom->prop1, $objectTo->prop1);
        $this->assertEquals(null, $objectTo->prop2);
        $this->assertEquals(0, $objectTo->prop3);
    }
}
