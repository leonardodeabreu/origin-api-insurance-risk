<?php declare(strict_types = 1);

namespace Tests\Api\InsuranceQuote\Builders;

use App\Api\InsuranceQuote\Builders\HomeEntity;
use PHPUnit\Framework\Assert;
use TestCase;

class HomeEntityTest extends TestCase
{
    /**
     * @param bool $isEligible
     * @param int $score
     *
     * @dataProvider buildHomeEntityDataProvider
     */
    public function test_HomeEntity_ShouldBuild(bool $isEligible, int $score): void
    {
        $homeEntity = HomeEntity::builder()
            ->setEligible($isEligible)
            ->setScore($score)
            ->build();

        Assert::assertInstanceOf(HomeEntity::class, $homeEntity);

        Assert::assertEquals($isEligible, $homeEntity->isEligible());
        Assert::assertEquals($score, $homeEntity->getScore());
    }

    public function test_HomeEntity_ShouldRenderAsArray(): void
    {
        $homeEntity = HomeEntity::builder()
            ->setEligible($isEligible = true)
            ->setScore($score = 10)
            ->build();

        $homeEntityArray = $homeEntity->asArray();

        Assert::assertIsArray($homeEntityArray);

        Assert::assertArrayHasKey('eligible', $homeEntityArray);
        Assert::assertArrayHasKey('score', $homeEntityArray);
    }

    public function buildHomeEntityDataProvider(): iterable
    {
        yield [true, 2];
        yield [true, 2];
        yield [false, 3];
    }
}
