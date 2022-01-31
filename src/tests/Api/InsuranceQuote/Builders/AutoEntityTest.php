<?php declare(strict_types = 1);

namespace Tests\Api\InsuranceQuote\Builders;

use App\Api\InsuranceQuote\Builders\AutoEntity;
use PHPUnit\Framework\Assert;
use TestCase;

class AutoEntityTest extends TestCase
{
    /**
     * @param bool $isEligible
     * @param int $score
     *
     * @dataProvider buildAutoEntityDataProvider
     */
    public function test_AutoEntity_ShouldBuild(bool $isEligible, int $score): void
    {
        $autoEntity = AutoEntity::builder()
            ->setEligible($isEligible)
            ->setScore($score)
            ->build();

        Assert::assertInstanceOf(AutoEntity::class, $autoEntity);

        Assert::assertEquals($isEligible, $autoEntity->isEligible());
        Assert::assertEquals($score, $autoEntity->getScore());
    }

    public function test_AutoEntity_ShouldRenderAsArray(): void
    {
        $autoEntity = AutoEntity::builder()
            ->setEligible($isEligible = true)
            ->setScore($score = 10)
            ->build();

        $autoEntityArray = $autoEntity->asArray();

        Assert::assertIsArray($autoEntityArray);

        Assert::assertArrayHasKey('eligible', $autoEntityArray);
        Assert::assertArrayHasKey('score', $autoEntityArray);
    }

    public function buildAutoEntityDataProvider(): iterable
    {
        yield [true, 2];
        yield [true, 2];
        yield [false, 3];
    }
}
