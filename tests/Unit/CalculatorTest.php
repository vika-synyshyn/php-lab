
<?php

namespace Tests\Unit;

use App\Services\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function test_add()
    {
        $calculator = new Calculator;
        $this->assertEquals(5, $calculator->add(2, 3));
    }

    public function test_subtract()
    {
        $calculator = new Calculator;
        $this->assertEquals(3, $calculator->subtract(5, 2));
    }

    public function test_multiply()
    {
        $calculator = new Calculator;
        $this->assertEquals(20, $calculator->multiply(4, 5));
        $this->assertEquals(-6, $calculator->multiply(-3, 2));
        $this->assertEquals(0, $calculator->multiply(0, 7));
    }
}
