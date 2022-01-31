<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Enums;

use Illuminate\Support\Str;

/**
 * @method static string owned()
 * @method static string mortgaged()
 */
final class OwnershipStatusEnum
{
    private const OWNED = 'owned';
    private const MORTGAGED = 'mortgaged';

    public static function __callStatic($name, $arguments): string
    {
        return constant('self::' . strtoupper(Str::snake($name)));
    }

    public static function getAll(): string
    {
        return sprintf('%s,%s', self::OWNED, self::MORTGAGED);
    }
}
