<?php

namespace Tests\Api\InsuranceQuote\Rules;

use App\Api\InsuranceQuote\Builders\AutoEntity;
use App\Api\InsuranceQuote\Builders\DisabilityEntity;
use App\Api\InsuranceQuote\Builders\HomeEntity;
use App\Api\InsuranceQuote\Builders\LifeEntity;
use App\Api\InsuranceQuote\Rules\InsuranceAgeRuling;
use PHPUnit\Framework\Assert;
use TestCase;

class InsuranceAgeRulingTest extends TestCase
{
    public function test_Apply_ShouldDeductTwoRiskPoints_IfUserIsUnderThenThirtyYears(): void
    {
        [$autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance] = $this->buildEntities();

        InsuranceAgeRuling::apply($userAge = 29, $autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance);

        Assert::assertEquals(-2, $autoInsurance->build()->getScore());
        Assert::assertEquals(-2, $lifeInsurance->build()->getScore());
        Assert::assertEquals(-2, $disabilityInsurance->build()->getScore());
        Assert::assertEquals(-2, $homeInsurance->build()->getScore());
    }

    /**
     * @param integer $userAge
     * 
     * @dataProvider buildUsersWithAgeBetweenThirtyAndFourtyDataProvider
     */
    public function test_Apply_ShouldDeductOneRiskPoint_IfUserIsBetweenThirtyAndFourtyYears(int $userAge): void
    {
        [$autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance] = $this->buildEntities();

        InsuranceAgeRuling::apply($userAge, $autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance);

        Assert::assertEquals(-1, $autoInsurance->build()->getScore());
        Assert::assertEquals(-1, $lifeInsurance->build()->getScore());
        Assert::assertEquals(-1, $disabilityInsurance->build()->getScore());
        Assert::assertEquals(-1, $homeInsurance->build()->getScore());
    }

    public function test_Apply_ShouldSetAsIneligibleToDisabilityAndLife_IfUserIsOverThenSixtyYears(): void
    {
        [$autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance] = $this->buildEntities();

        InsuranceAgeRuling::apply($userAge = 61, $autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance);

        Assert::assertFalse($lifeInsurance->build()->isEligible());
        Assert::assertFalse($disabilityInsurance->build()->isEligible());
        // still eligible for these.
        Assert::assertTrue($autoInsurance->build()->isEligible());
        Assert::assertTrue($homeInsurance->build()->isEligible());
    }

    public function buildUsersWithAgeBetweenThirtyAndFourtyDataProvider(): iterable
    {
        yield [30];
        yield [40];
        yield [35];
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
