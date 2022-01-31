<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Services;

use App\Api\InsuranceQuote\Enums\LineOfInsuranceRiskEnum;

final class LineOfInsuranceRiskMapper
{
    public static function get(bool $isEligible, int $score): string
    {
        if (!$isEligible) {
            return LineOfInsuranceRiskEnum::ineligible();
        }

        if ($score <= 0) {
            return LineOfInsuranceRiskEnum::economic();
        }

        if ($score >= 1 && $score <= 2) {
            return LineOfInsuranceRiskEnum::regular();
        }

        return LineOfInsuranceRiskEnum::responsible();
    }
}
