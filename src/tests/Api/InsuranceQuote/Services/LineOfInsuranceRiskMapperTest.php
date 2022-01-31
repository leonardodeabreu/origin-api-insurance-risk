<?php

namespace Tests\Api\InsuranceQuote\Services;

use App\Api\InsuranceQuote\Enums\LineOfInsuranceRiskEnum;
use App\Api\InsuranceQuote\Services\LineOfInsuranceRiskMapper;
use PHPUnit\Framework\Assert;
use TestCase;

class LineOfInsuranceRiskMapperTest extends TestCase
{
    public function test_Get_ShouldReturnIneligible_IfIsEligibleIsFalse(): void
    {
        $risk = LineOfInsuranceRiskMapper::get($isEligible = false, $score = 10);

        Assert::assertEquals(LineOfInsuranceRiskEnum::ineligible(), $risk);
    }

    /**
     * @param integer $score
     * 
     * @dataProvider buildScoreZeroOrBelowDataProvider
     */
    public function test_Get_ShouldReturnEconomic_IfScoreIsZeroOrBelow_AndIsEligibleIsTrue(int $score): void
    {
        $risk = LineOfInsuranceRiskMapper::get($isEligible = true, $score);

        Assert::assertEquals(LineOfInsuranceRiskEnum::economic(), $risk);
    }

    public function buildScoreZeroOrBelowDataProvider(): iterable
    {
        yield [0];
        yield [-10];
    }

    /**
     * @param integer $score
     * 
     * @dataProvider buildScoreOneAndTwoDataProvider
     */
    public function test_Get_ShouldReturnRegular_IfScoreIsOneOrTwo_AndIsEligibleIsTrue(int $score): void
    {
        $risk = LineOfInsuranceRiskMapper::get($isEligible = true, $score);

        Assert::assertEquals(LineOfInsuranceRiskEnum::regular(), $risk);
    }

    public function buildScoreOneAndTwoDataProvider(): iterable
    {
        yield [1];
        yield [2];
    }

    /**
     * @param integer $score
     * 
     * @dataProvider buildScoreMoreThanTwoDataProvider
     */
    public function test_Get_ShouldReturnResponsible_IfScoreIsMoreThenTwo_AndIsEligibleIsTrue(int $score): void
    {
        $risk = LineOfInsuranceRiskMapper::get($isEligible = true, $score);

        Assert::assertEquals(LineOfInsuranceRiskEnum::responsible(), $risk);
    }

    public function buildScoreMoreThanTwoDataProvider(): iterable
    {
        yield [3];
        yield [10];
        yield [50];
    }
}
