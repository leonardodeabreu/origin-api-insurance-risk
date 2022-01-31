<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Services;

use App\Api\InsuranceQuote\Builders\AutoEntity;
use App\Api\InsuranceQuote\Builders\AutoEntityBuilder;
use App\Api\InsuranceQuote\Builders\DisabilityEntity;
use App\Api\InsuranceQuote\Builders\DisabilityEntityBuilder;
use App\Api\InsuranceQuote\Builders\HomeEntity;
use App\Api\InsuranceQuote\Builders\HomeEntityBuilder;
use App\Api\InsuranceQuote\Builders\InsuranceRiskLineEntity;
use App\Api\InsuranceQuote\Builders\LifeEntity;
use App\Api\InsuranceQuote\Builders\LifeEntityBuilder;
use App\Api\InsuranceQuote\Dto\InsuranceQuoteDto;
use App\Api\InsuranceQuote\Enums\MaritalStatusEnum;
use App\Api\InsuranceQuote\Interfaces\CalculateRiskServiceInterface;
use App\Api\InsuranceQuote\Rules\InsuranceAgeRuling;
use App\Api\InsuranceQuote\Rules\InsuranceDependentRuling;
use App\Api\InsuranceQuote\Rules\InsuranceIncomeRuling;
use App\Api\InsuranceQuote\Rules\InsuranceMaritalStatusRuling;
use App\Api\InsuranceQuote\Rules\InsuranceOwnershipRuling;
use App\Api\InsuranceQuote\Rules\InsuranceVehiclesRuling;

final class CalculateRiskService implements CalculateRiskServiceInterface
{
    public function calculate(InsuranceQuoteDto $dto): array
    {
        [$autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance] = $this->buildEntities();
        
        $score = $this->calculateBaseScore($dto->getRiskQuestions());
        
        $this->applyScoreToEachLineOfInsurance($score, $autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance);
        
        InsuranceAgeRuling::apply($dto->getAge(), $autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance);
        InsuranceIncomeRuling::apply($dto->getIncome(), $autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance);
        InsuranceOwnershipRuling::apply($dto->getOwnershipStatus(), $disabilityInsurance, $homeInsurance);

        if ($dto->getDependents() > 0) {
            InsuranceDependentRuling::apply($lifeInsurance, $disabilityInsurance);
        }

        if ($dto->getMaritalStatus() === MaritalStatusEnum::married()) {
            InsuranceMaritalStatusRuling::apply($lifeInsurance, $disabilityInsurance);
        }

        InsuranceVehiclesRuling::apply($dto->getVehicleYear(), $autoInsurance);
        
        return InsuranceRiskLineEntity::builder()
            ->setAuto($autoInsurance)
            ->setHome($homeInsurance)
            ->setDisability($disabilityInsurance)
            ->setLife($lifeInsurance)
            ->build()
            ->asArray();
    }

    private function buildEntities(): array
    {
        $autoInsurance = AutoEntity::builder();
        $lifeInsurance = LifeEntity::builder();
        $disabilityInsurance = DisabilityEntity::builder();
        $homeInsurance = HomeEntity::builder();

        return [$autoInsurance, $lifeInsurance, $disabilityInsurance, $homeInsurance];
    }

    private function calculateBaseScore(array $riskQuestions): int
    {
        return count(array_filter($riskQuestions));
    }

    private function applyScoreToEachLineOfInsurance(
        int $score, 
        AutoEntityBuilder $autoInsurance,
        LifeEntityBuilder $lifeInsurance, 
        DisabilityEntityBuilder $disabilityInsurance, 
        HomeEntityBuilder $homeInsurance
    ): void {
        $autoInsurance->setScore($score);
        $lifeInsurance->setScore($score);
        $disabilityInsurance->setScore($score);
        $homeInsurance->setScore($score);
    }
}
