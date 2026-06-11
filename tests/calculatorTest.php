<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/calculator.php';

class CalculatorTest extends TestCase {
    private $calc;

    protected function setUp(): void {
        $this->calc = new Calculator();
    }

    public function testAdd() {
        $this->assertEquals(10, $this->calc->add(4, 6));
    }

    public function testSubtract() {
        $this->assertEquals(5, $this->calc->subtract(10, 5));
    }

    public function testMultiply() {
        $this->assertEquals(12, $this->calc->multiply(3, 4));
    }

    public function testDivide() {
        $this->assertEquals(5, $this->calc->divide(10, 2));
    }

    public function testDivideByZero() {
        $this->expectException(InvalidArgumentException::class);
        $this->calc->divide(10, 0);
    }
}