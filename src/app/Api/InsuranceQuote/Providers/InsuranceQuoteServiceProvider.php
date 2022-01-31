<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Providers;

use App\Api\InsuranceQuote\Interfaces\CalculateRiskServiceInterface;
use App\Api\InsuranceQuote\Services\CalculateRiskService;
use Illuminate\Support\ServiceProvider;

class InsuranceQuoteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            CalculateRiskServiceInterface::class,
            CalculateRiskService::class
        );
    }
}
