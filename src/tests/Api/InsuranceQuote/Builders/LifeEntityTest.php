<?php declare(strict_types = 1);

namespace Tests\Api\InsuranceQuote\Builders;

use App\Api\InsuranceQuote\Builders\LifeEntity;
use PHPUnit\Framework\Assert;
use TestCase;

class LifeEntityTest extends TestCase
{
    /**
     * @param bool $isEligible
     * @param int $score
     *
     * @dataProvider buildLifeEntityDataProvider
     */
    public function test_LifeEntity_ShouldBuild(bool $isEligible, int $score): void
    {
        $lifeEntity = LifeEntity::builder()
            ->setEligible($isEligible)
            ->setScore($score)
            ->build();

        Assert::assertInstanceOf(LifeEntity::class, $lifeEntity);

        Assert::assertEquals($isEligible, $lifeEntity->isEligible());
        Assert::assertEquals($score, $lifeEntity->getScore());
    }

    public function test_LifeEntity_ShouldRenderAsArray(): void
    {
        $lifeEntity = LifeEntity::builder()
            ->setEligible($isEligible = true)
            ->setScore($score = 10)
            ->build();

        $lifeEntityArray = $lifeEntity->asArray();

        Assert::assertIsArray($lifeEntityArray);

        Assert::assertArrayHasKey('eligible', $lifeEntityArray);
        Assert::assertArrayHasKey('score', $lifeEntityArray);
    }

    public function buildLifeEntityDataProvider(): iterable
    {
        yield [true, 2];
        yield [true, 2];
        yield [false, 3];
    }
}
