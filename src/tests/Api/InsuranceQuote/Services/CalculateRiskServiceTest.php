<?php

namespace Tests\Api\InsuranceQuote\Services;

use App\Api\InsuranceQuote\Dto\InsuranceQuoteDto;
use App\Api\InsuranceQuote\Services\CalculateRiskService;
use PHPUnit\Framework\Assert;
use TestCase;

class CalculateRiskServiceTest extends TestCase
{
    public function test_Calculate_ShouldReturnArray(): void
    {
        $request = [
            'age' => 35,
            'dependents' => 2,
            'house' => ['ownership_status' => 'owned'],
            'income' => 0,
            'marital_status' => "married",
            'risk_questions' => [0, 1, 0],
            'vehicle' => ['year' => 2018],
        ];

        $insuranceQuoteDto = InsuranceQuoteDto::fromArray($request);
        $calculatedRisks = (new CalculateRiskService())->calculate($insuranceQuoteDto);

        Assert::assertIsArray($calculatedRisks);

        Assert::assertArrayHasKey('auto', $calculatedRisks);
        Assert::assertArrayHasKey('life', $calculatedRisks);
        Assert::assertArrayHasKey('disability', $calculatedRisks);
        Assert::assertArrayHasKey('home', $calculatedRisks);
    }

    public function test_Calculate_ShouldThrowAnException_IfWasReceivedAnIncorrectRequest(): void
    {
        $this->expectException(\Exception::class);

        $insuranceQuoteDto = InsuranceQuoteDto::fromArray($request = []);
        (new CalculateRiskService())->calculate($insuranceQuoteDto);
    }
}
