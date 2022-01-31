<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Rules;

use App\Api\InsuranceQuote\Builders\AutoEntityBuilder;
use App\Api\InsuranceQuote\Builders\DisabilityEntityBuilder;
use App\Api\InsuranceQuote\Builders\HomeEntityBuilder;
use App\Api\InsuranceQuote\Builders\LifeEntityBuilder;

final class InsuranceIncomeRuling
{
    private const INELIGIBLE = false;

    public static function apply(
        int $income,
        AutoEntityBuilder $autoInsurance,
        LifeEntityBuilder $lifeInsurance, 
        DisabilityEntityBuilder $disabilityInsurance, 
        HomeEntityBuilder $homeInsurance
    ): void {
        if ($income <= 0) {
            $disabilityInsurance->setEligible(self::INELIGIBLE);
        } else if ($income > 200000) {
            $autoInsurance->setScore($autoInsurance->getScore() - 1);
            $lifeInsurance->setScore($lifeInsurance->getScore() - 1);
            $disabilityInsurance->setScore($disabilityInsurance->getScore() - 1);
            $homeInsurance->setScore($homeInsurance->getScore() - 1);
        }
    }
}
