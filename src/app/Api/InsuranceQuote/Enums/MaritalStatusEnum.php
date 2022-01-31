<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Enums;

use Illuminate\Support\Str;

/**
 * @method static string single()
 * @method static string married()
 */
final class MaritalStatusEnum
{
    private const SINGLE = 'single';
    private const MARRIED = 'married';

    public static function __callStatic($name, $arguments): string
    {
        return constant('self::' . strtoupper(Str::snake($name)));
    }

    public static function getAll(): string
    {
        return sprintf('%s,%s', self::SINGLE, self::MARRIED);
    }
}
