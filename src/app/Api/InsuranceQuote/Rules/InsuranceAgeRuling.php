<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Rules;

use App\Api\InsuranceQuote\Builders\AutoEntityBuilder;
use App\Api\InsuranceQuote\Builders\DisabilityEntityBuilder;
use App\Api\InsuranceQuote\Builders\HomeEntityBuilder;
use App\Api\InsuranceQuote\Builders\LifeEntityBuilder;

final class InsuranceAgeRuling
{
    private const INELIGIBLE = false;

    public static function apply(
        int $age,
        AutoEntityBuilder $autoInsurance,
        LifeEntityBuilder $lifeInsurance, 
        DisabilityEntityBuilder $disabilityInsurance, 
        HomeEntityBuilder $homeInsurance
    ): void {
        if ($age < 30) {
            $autoInsurance->setScore($autoInsurance->getScore() - 2);
            $lifeInsurance->setScore($lifeInsurance->getScore() - 2);
            $disabilityInsurance->setScore($disabilityInsurance->getScore() - 2);
            $homeInsurance->setScore($homeInsurance->getScore() - 2);
        } else if ($age >= 30 && $age <= 40) {
            $autoInsurance->setScore($autoInsurance->getScore() - 1);
            $lifeInsurance->setScore($lifeInsurance->getScore() - 1);
            $disabilityInsurance->setScore($disabilityInsurance->getScore() - 1);
            $homeInsurance->setScore($homeInsurance->getScore() - 1);
        } else if ($age > 60) {
            $disabilityInsurance->setEligible(self::INELIGIBLE);
            $lifeInsurance->setEligible(self::INELIGIBLE);
        }
    }
}
