<?php declare(strict_types = 1);

namespace Tests\Api\InsuranceQuote\Builders;

use App\Api\InsuranceQuote\Builders\AutoEntity;
use App\Api\InsuranceQuote\Builders\DisabilityEntity;
use App\Api\InsuranceQuote\Builders\HomeEntity;
use App\Api\InsuranceQuote\Builders\InsuranceRiskLineEntity;
use App\Api\InsuranceQuote\Builders\LifeEntity;
use PHPUnit\Framework\Assert;
use TestCase;

class InsuranceRiskLineEntityTest extends TestCase
{
    public function test_InsuranceRiskLineEntity_ShouldBuild(): void
    {
        $auto = AutoEntity::builder()
            ->setEligible($autoEligible = false)
            ->setScore($autoScore = 3);

        $home = HomeEntity::builder()
            ->setEligible($homeEligible = true)
            ->setScore($homeScore = 2);

        $disability = DisabilityEntity::builder()
            ->setEligible($disabilityEligible = false)
            ->setScore($disabilityScore = 2);
        
        $life = LifeEntity::builder()
            ->setEligible($lifeEligible = true)
            ->setScore($lifeScore = 0);

        $insuranceRiskLineEntity = InsuranceRiskLineEntity::builder()
            ->setAuto($auto)
            ->setHome($home)
            ->setDisability($disability)
            ->setLife($life)
            ->build();

        Assert::assertInstanceOf(InsuranceRiskLineEntity::class, $insuranceRiskLineEntity);
        Assert::assertInstanceOf(AutoEntity::class, $insuranceRiskLineEntity->getAuto());
        Assert::assertInstanceOf(HomeEntity::class, $insuranceRiskLineEntity->getHome());
        Assert::assertInstanceOf(DisabilityEntity::class, $insuranceRiskLineEntity->getDisability());
        Assert::assertInstanceOf(LifeEntity::class, $insuranceRiskLineEntity->getLife());
    }

    public function test_InsuranceRiskLineEntity_ShouldRenderAsArray(): void
    {
        $auto = AutoEntity::builder()
            ->setEligible($autoEligible = false)
            ->setScore($autoScore = 3);

        $home = HomeEntity::builder()
            ->setEligible($homeEligible = true)
            ->setScore($homeScore = 2);

        $disability = DisabilityEntity::builder()
            ->setEligible($disabilityEligible = false)
            ->setScore($disabilityScore = 2);
        
        $life = LifeEntity::builder()
            ->setEligible($lifeEligible = true)
            ->setScore($lifeScore = 0);

        $insuranceRiskLineEntity = InsuranceRiskLineEntity::builder()
            ->setAuto($auto)
            ->setHome($home)
            ->setDisability($disability)
            ->setLife($life)
            ->build();

        $insuranceRiskLineEntityArray = $insuranceRiskLineEntity->asArray();

        Assert::assertIsArray($insuranceRiskLineEntityArray);

        Assert::assertArrayHasKey('auto', $insuranceRiskLineEntityArray);
        Assert::assertArrayHasKey('home', $insuranceRiskLineEntityArray);
        Assert::assertArrayHasKey('disability', $insuranceRiskLineEntityArray);
        Assert::assertArrayHasKey('life', $insuranceRiskLineEntityArray);
    }
}
