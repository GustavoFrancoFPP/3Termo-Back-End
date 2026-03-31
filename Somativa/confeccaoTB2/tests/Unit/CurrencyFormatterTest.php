<?php

namespace Tests\Unit;

use App\Support\CurrencyFormatter;
use PHPUnit\Framework\TestCase;

class CurrencyFormatterTest extends TestCase
{
    public function test_it_normalizes_brazilian_currency_input(): void
    {
        $this->assertSame('1234.56', CurrencyFormatter::normalize('1.234,56'));
        $this->assertSame('1234.56', CurrencyFormatter::fromInput('123456'));
        $this->assertSame(1234.56, CurrencyFormatter::toFloat('1.234,56'));
    }

    public function test_it_formats_numeric_values_for_display(): void
    {
        $this->assertSame('1.234,56', CurrencyFormatter::formatForInput(1234.56));
    }
}
