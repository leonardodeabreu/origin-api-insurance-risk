<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Resources;

use App\Api\InsuranceQuote\Services\LineOfInsuranceRiskMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class CalculateRiskResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        if (!$resource = $this->resource) {
            return [];
        }

        return [
            'auto' => LineOfInsuranceRiskMapper::get(Arr::get($resource, 'auto.eligible'), Arr::get($resource, 'auto.score')),
            'disability' => LineOfInsuranceRiskMapper::get(Arr::get($resource, 'disability.eligible'), Arr::get($resource, 'disability.score')),
            'home' => LineOfInsuranceRiskMapper::get(Arr::get($resource, 'home.eligible'), Arr::get($resource, 'home.score')),
            'life' => LineOfInsuranceRiskMapper::get(Arr::get($resource, 'life.eligible'), Arr::get($resource, 'life.score')),
        ];
    }

}
