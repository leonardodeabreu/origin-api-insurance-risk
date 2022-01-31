<?php

namespace Tests\Api\InsuranceQuote\Rules;

use App\Api\InsuranceQuote\Builders\AutoEntity;
use App\Api\InsuranceQuote\Builders\DisabilityEntity;
use App\Api\InsuranceQuote\Builders\HomeEntity;
use App\Api\InsuranceQuote\Builders\LifeEntity;
use App\Api\InsuranceQuote\Rules\InsuranceIncomeRuling;
use PHPUnit\Framework\Assert;
use TestCase;

class InsuranceIncomeRulingTest extends TestCase
{
    public function test_Apply_ShouldDeductOneRiskPoint_IfUserHaveIncomeAbove200k(): void
    {
        [$autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance] = $this->buildEntities();

        InsuranceIncomeRuling::apply($income = 200001, $autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance);

        Assert::assertEquals(-1, $autoInsurance->build()->getScore());
        Assert::assertEquals(-1, $lifeInsurance->build()->getScore());
        Assert::assertEquals(-1, $disabilityInsurance->build()->getScore());
        Assert::assertEquals(-1, $homeInsurance->build()->getScore());
    }

    public function test_Apply_ShouldNotAddRiskPoints_IfUserHaveIncomeBetweenZeroAnd200k(): void
    {
        [$autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance] = $this->buildEntities();

        InsuranceIncomeRuling::apply($income = 200000, $autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance);

        Assert::assertEquals(0, $autoInsurance->build()->getScore());
        Assert::assertEquals(0, $lifeInsurance->build()->getScore());
        Assert::assertEquals(0, $disabilityInsurance->build()->getScore());
        Assert::assertEquals(0, $homeInsurance->build()->getScore());
    }

    public function test_Apply_ShouldSetAsIneligibleToDisability_IfUserDoesNotHaveIncome(): void
    {
        [$autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance] = $this->buildEntities();

        InsuranceIncomeRuling::apply($income = 0, $autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance);

        Assert::assertFalse($disabilityInsurance->build()->isEligible());
        // still eligible for these.
        Assert::assertTrue($lifeInsurance->build()->isEligible());
        Assert::assertTrue($autoInsurance->build()->isEligible());
        Assert::assertTrue($homeInsurance->build()->isEligible());
    }

    private function buildEntities(): array
    {
        $autoInsurance = AutoEntity::builder();
        $lifeInsurance = LifeEntity::builder();
        $disabilityInsurance = DisabilityEntity::builder();
        $homeInsurance = HomeEntity::builder();

        return [$autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance];
    }
}
