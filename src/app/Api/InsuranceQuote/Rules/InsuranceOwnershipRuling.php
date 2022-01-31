<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Rules;

use App\Api\InsuranceQuote\Builders\DisabilityEntityBuilder;
use App\Api\InsuranceQuote\Builders\HomeEntityBuilder;
use App\Api\InsuranceQuote\Enums\OwnershipStatusEnum;

final class InsuranceOwnershipRuling
{
    private const INELIGIBLE = false;

    public static function apply(
        ?string $status,
        DisabilityEntityBuilder $disabilityInsurance, 
        HomeEntityBuilder $homeInsurance
    ): void {
        if (is_null($status)) {
            $homeInsurance->setEligible(self::INELIGIBLE);
        } else if ($status === OwnershipStatusEnum::mortgaged()) {
            $homeInsurance->setScore($homeInsurance->getScore() + 1);
            $disabilityInsurance->setScore($disabilityInsurance->getScore() + 1);
        }
    }
}
