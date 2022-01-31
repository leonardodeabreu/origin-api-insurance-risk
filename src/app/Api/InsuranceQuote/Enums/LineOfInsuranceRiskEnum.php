<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Enums;

use Illuminate\Support\Str;

/**
 * @method static string ineligible()
 * @method static string economic()
 * @method static string regular()
 * @method static string responsible()
 */
final class LineOfInsuranceRiskEnum
{
    private const INELIGIBLE = 'ineligible';
    private const ECONOMIC = 'economic';
    private const REGULAR = 'regular';
    private const RESPONSIBLE = 'responsible';

    public static function __callStatic($name, $arguments): string
    {
        return constant('self::' . strtoupper(Str::snake($name)));
    }
}
