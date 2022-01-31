<?php declare(strict_types = 1);

namespace Tests\Api\InsuranceQuote\Builders;

use App\Api\InsuranceQuote\Builders\DisabilityEntity;
use PHPUnit\Framework\Assert;
use TestCase;

class DisabilityEntityTest extends TestCase
{
    /**
     * @param bool $isEligible
     * @param int $score
     *
     * @dataProvider buildDisabilityEntityDataProvider
     */
    public function test_DisabilityEntity_ShouldBuild(bool $isEligible, int $score): void
    {
        $disabilityEntity = DisabilityEntity::builder()
            ->setEligible($isEligible)
            ->setScore($score)
            ->build();

        Assert::assertInstanceOf(DisabilityEntity::class, $disabilityEntity);

        Assert::assertEquals($isEligible, $disabilityEntity->isEligible());
        Assert::assertEquals($score, $disabilityEntity->getScore());
    }

    public function test_DisabilityEntity_ShouldRenderAsArray(): void
    {
        $disabilityEntity = DisabilityEntity::builder()
            ->setEligible($isEligible = true)
            ->setScore($score = 10)
            ->build();

        $disabilityEntityArray = $disabilityEntity->asArray();

        Assert::assertIsArray($disabilityEntityArray);

        Assert::assertArrayHasKey('eligible', $disabilityEntityArray);
        Assert::assertArrayHasKey('score', $disabilityEntityArray);
    }

    public function buildDisabilityEntityDataProvider(): iterable
    {
        yield [true, 2];
        yield [true, 2];
        yield [false, 3];
    }
}
