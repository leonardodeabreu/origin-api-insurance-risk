<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Rules;

use App\Api\InsuranceQuote\Builders\DisabilityEntityBuilder;
use App\Api\InsuranceQuote\Builders\LifeEntityBuilder;

final class InsuranceDependentRuling
{
    public static function apply(
        LifeEntityBuilder $lifeInsurance,
        DisabilityEntityBuilder $disabilityInsurance
    ): void {
        $lifeInsurance->setScore($lifeInsurance->getScore() + 1);
        $disabilityInsurance->setScore($disabilityInsurance->getScore() + 1);
    }
}
