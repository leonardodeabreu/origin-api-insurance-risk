<?php

namespace Tests\Api\InsuranceQuote\Resources;

use App\Api\InsuranceQuote\Enums\LineOfInsuranceRiskEnum;
use App\Api\InsuranceQuote\Resources\CalculateRiskResource;
use Illuminate\Http\Request;
use PHPUnit\Framework\Assert;
use TestCase;

class CalculateRiskResourceTest extends TestCase
{
    /** @var Request */
    private $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new Request();
    }

    public function test_InvalidCalculateRiskResource_ShouldReturnsEmptyArray(): void
    {
        $resource = new CalculateRiskResource(null);
        $risks = $resource->toArray($this->request);

        Assert::assertEmpty($risks);
    }

    public function test_CalculateRiskResource_ShouldReturnDataArray(): void
    {
        $risks = [[
            'auto' => ['eligible' => true, 'score' => 2],
            'disability' => ['eligible' => true, 'score' => -2],
            'home' => ['eligible' => false, 'score' => 1],
            'life' => ['eligible' => false, 'score' => 6],
        ]];

        $resource = CalculateRiskResource::collection($risks);
        $riskInformationData = $resource->toArray($this->request);

        Assert::assertIsArray($riskInformationData);

        foreach ($riskInformationData as $risk) {
            Assert::assertEquals($risk['auto'], LineOfInsuranceRiskEnum::regular());
            Assert::assertEquals($risk['disability'], LineOfInsuranceRiskEnum::economic());
            Assert::assertEquals($risk['home'], LineOfInsuranceRiskEnum::ineligible());
            Assert::assertEquals($risk['life'], LineOfInsuranceRiskEnum::ineligible());
        }
    }
}
