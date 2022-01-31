<?php

namespace Tests\Api\InsuranceQuote\Rules;

use App\Api\InsuranceQuote\Builders\DisabilityEntity;
use App\Api\InsuranceQuote\Builders\LifeEntity;
use App\Api\InsuranceQuote\Rules\InsuranceDependentRuling;
use PHPUnit\Framework\Assert;
use TestCase;

class InsuranceDependentRulingTest extends TestCase
{
    public function test_Apply_ShouldAddOneRiskPoint_InLifeAndDisabilityInsurance(): void
    {
        [$lifeInsurance, $disabilityInsurance] = $this->buildEntities();

        InsuranceDependentRuling::apply($lifeInsurance, $disabilityInsurance);

        Assert::assertEquals(1, $lifeInsurance->build()->getScore());
        Assert::assertEquals(1, $disabilityInsurance->build()->getScore());
    }

    private function buildEntities(): array
    {
        $lifeInsurance = LifeEntity::builder();
        $disabilityInsurance = DisabilityEntity::builder();

        return [$lifeInsurance, $disabilityInsurance];
    }
}
