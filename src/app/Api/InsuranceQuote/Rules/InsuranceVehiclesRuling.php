<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Rules;

use App\Api\InsuranceQuote\Builders\AutoEntityBuilder;

final class InsuranceVehiclesRuling
{
    private const INELIGIBLE = false;

    public static function apply(?int $vehicleYear, AutoEntityBuilder $autoInsurance): void
    {
        if (is_null($vehicleYear)) {
            $autoInsurance->setEligible(self::INELIGIBLE);
        } else if ((date('Y') - $vehicleYear) <= 5) {
            $autoInsurance->setScore($autoInsurance->getScore() + 1);
        }
    }
}
