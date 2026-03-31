<?php

namespace App\Support;

class CurrencyFormatter
{
    public static function normalize(mixed $value): ?string
    {
        if (blank($value) && $value !== 0 && $value !== '0') {
            return null;
        }

        if (is_int($value) || is_float($value)) {
            return number_format((float) $value, 2, '.', '');
        }

        $normalized = preg_replace('/[^\d,.-]/', '', trim((string) $value));

        if (blank($normalized) && $normalized !== '0') {
            return null;
        }

        if (str_contains($normalized, ',') && str_contains($normalized, '.')) {
            $normalized = str_replace('.', '', $normalized);
            $normalized = str_replace(',', '.', $normalized);
        } elseif (str_contains($normalized, ',')) {
            $normalized = str_replace(',', '.', $normalized);
        }

        return number_format((float) $normalized, 2, '.', '');
    }

    public static function fromInput(mixed $value): ?string
    {
        if (blank($value) && $value !== 0 && $value !== '0') {
            return null;
        }

        $value = trim((string) $value);
        $digitsOnly = preg_replace('/\D/', '', $value);

        if ($value === $digitsOnly && $digitsOnly !== '') {
            return number_format(((float) $digitsOnly) / 100, 2, '.', '');
        }

        return static::normalize($value);
    }

    public static function toFloat(mixed $value): float
    {
        return (float) (static::normalize($value) ?? 0);
    }

    public static function formatForInput(mixed $value): string
    {
        return number_format(static::toFloat($value), 2, ',', '.');
    }
}
