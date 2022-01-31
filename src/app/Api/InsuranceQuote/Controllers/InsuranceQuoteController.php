<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Controllers;

use App\Api\InsuranceQuote\Dto\InsuranceQuoteDto;
use App\Api\InsuranceQuote\Enums\MaritalStatusEnum;
use App\Api\InsuranceQuote\Enums\OwnershipStatusEnum;
use App\Api\InsuranceQuote\Interfaces\CalculateRiskServiceInterface;
use App\Api\InsuranceQuote\Resources\CalculateRiskResource;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class InsuranceQuoteController extends BaseController
{
    /** @var CalculateRiskServiceInterface $service */
    protected $service;

    public function __construct(CalculateRiskServiceInterface $service)
    {
        $this->service = $service;
    }

    public function calculateRisk(Request $request): CalculateRiskResource
    {
        $this->validate($request, [
            'age' => 'required|integer|min:0',
            'dependents' => 'required|integer|min:0',
            'income' => 'required|integer|min:0',
            'marital_status' => 'required|string|in:' . MaritalStatusEnum::getAll(),
            
            'risk_questions' => 'required|array|min:3|max:3',
            'risk_questions.*' => 'required|boolean',
            
            'vehicle' => 'nullable|array',
            'vehicle.year' => 'required_with:vehicle|integer',
            
            'house' => 'nullable|array',
            'house.ownership_status' => 'required_with:house|string|in:'. OwnershipStatusEnum::getAll(),
        ]);

        try {
            $risks = $this->service->calculate(InsuranceQuoteDto::fromArray($request->all()));

            return new CalculateRiskResource($risks);
        } catch(\Exception $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }
}
