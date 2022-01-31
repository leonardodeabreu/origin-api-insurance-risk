<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Interfaces;

use App\Api\InsuranceQuote\Dto\InsuranceQuoteDto;

interface CalculateRiskServiceInterface
{
    public function calculate(InsuranceQuoteDto $dto);
}
