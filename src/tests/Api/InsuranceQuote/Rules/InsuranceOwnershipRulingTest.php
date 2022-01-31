<?php

namespace Tests\Api\InsuranceQuote\Rules;

use App\Api\InsuranceQuote\Builders\DisabilityEntity;
use App\Api\InsuranceQuote\Builders\HomeEntity;
use App\Api\InsuranceQuote\Enums\OwnershipStatusEnum;
use App\Api\InsuranceQuote\Rules\InsuranceOwnershipRuling;
use PHPUnit\Framework\Assert;
use TestCase;

class InsuranceOwnershipRulingTest extends TestCase
{
    public function test_Apply_ShouldAddOneRiskPoint_IfStatusIsMortgaged(): void
    {
        [$disabilityInsurance, $homeInsurance] = $this->buildEntities();

        $ownershipStatus = OwnershipStatusEnum::mortgaged();

        InsuranceOwnershipRuling::apply($ownershipStatus, $disabilityInsurance, $homeInsurance);

        Assert::assertEquals(1, $disabilityInsurance->build()->getScore());
        Assert::assertEquals(1, $homeInsurance->build()->getScore());
    }

    public function test_Apply_ShouldNotAddOneRiskPoint_IfStatusIsOwned(): void
    {
        [$disabilityInsurance, $homeInsurance] = $this->buildEntities();

        $ownershipStatus = OwnershipStatusEnum::owned();

        InsuranceOwnershipRuling::apply($ownershipStatus, $disabilityInsurance, $homeInsurance);

        Assert::assertEquals(0, $disabilityInsurance->build()->getScore());
        Assert::assertEquals(0, $homeInsurance->build()->getScore());
    }

    public function test_Apply_ShouldSetAsIneligibleToHomeInsurance_IfDoNotHaveOwnershipStatus(): void
    {
        [$disabilityInsurance, $homeInsurance] = $this->buildEntities();

        InsuranceOwnershipRuling::apply($ownershipStatus = null, $disabilityInsurance, $homeInsurance);

        Assert::assertFalse($homeInsurance->build()->isEligible());
        // still eligible for these.
        Assert::asserttrue($disabilityInsurance->build()->isEligible());
    }

    private function buildEntities(): array
    {
        $disabilityInsurance = DisabilityEntity::builder();
        $homeInsurance = HomeEntity::builder();

        return [$disabilityInsurance, $homeInsurance];
    }
}
