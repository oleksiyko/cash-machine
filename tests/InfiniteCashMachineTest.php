<?php
namespace CashMachine;

use PHPUnit\Framework\TestCase;
use \InvalidArgumentException;

class InfiniteCashMachineTest extends TestCase
{
    /**
     * @var InfiniteCashMachine
     */
    private $cashMachine;

    public function setUp()
    {
        $this->cashMachine = new InfiniteCashMachine();
    }

    public function testWithdraw()
    {
        $this->assertEquals([], $this->cashMachine->withdraw(0));
        $this->assertEquals([20, 10], $this->cashMachine->withdraw(30));
        $this->assertEquals([100, 100, 50, 20, 20], $this->cashMachine->withdraw(290));
        $this->expectException(NoteUnavailableException::class);
        $this->cashMachine->withdraw(125);
        $this->expectException(InvalidArgumentException::class);
        $this->cashMachine->withdraw(-100);
    }
}