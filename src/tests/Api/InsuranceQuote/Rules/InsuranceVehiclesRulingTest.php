<?php

namespace Tests\Api\InsuranceQuote\Rules;

use App\Api\InsuranceQuote\Builders\AutoEntity;
use App\Api\InsuranceQuote\Rules\InsuranceVehiclesRuling;
use PHPUnit\Framework\Assert;
use TestCase;

class InsuranceVehiclesRulingTest extends TestCase
{
    public function test_Apply_ShouldAddOneRiskPointToAuto_IfVehicleWasProducedInTheLast5Years(): void
    {
        $autoInsurance = AutoEntity::builder();
        InsuranceVehiclesRuling::apply($vehicleYear = 2020, $autoInsurance);

        Assert::assertEquals(1, $autoInsurance->build()->getScore());
    }

    public function test_Apply_ShouldNotAddOneRiskPointToAuto_IfVehicleWasNotProducedInTheLast5Years(): void
    {
        $autoInsurance = AutoEntity::builder();
        InsuranceVehiclesRuling::apply($vehicleYear = 2010, $autoInsurance);

        Assert::assertEquals(0, $autoInsurance->build()->getScore());
    }

    public function test_Apply_ShouldSetAsIneligibleToHomeInsurance_IfDoNotHaveOwnershipStatus(): void
    {
        $autoInsurance = AutoEntity::builder();

        InsuranceVehiclesRuling::apply($vehicleYear = null, $autoInsurance);

        Assert::assertFalse($autoInsurance->build()->isEligible());
    }
}
