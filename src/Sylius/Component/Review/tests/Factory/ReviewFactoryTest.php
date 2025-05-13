<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Sylius\Component\Review\Factory;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Review\Factory\ReviewFactory;
use Sylius\Component\Review\Factory\ReviewFactoryInterface;
use Sylius\Component\Review\Model\ReviewableInterface;
use Sylius\Component\Review\Model\ReviewerInterface;
use Sylius\Component\Review\Model\ReviewInterface;
use Sylius\Resource\Factory\FactoryInterface;

final class ReviewFactoryTest extends TestCase
{
    /** @var FactoryInterface<ReviewInterface>&MockObject */
    private FactoryInterface $factoryMock;

    /** @var ReviewFactory<ReviewInterface> */
    private ReviewFactory $reviewFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factoryMock = $this->createMock(FactoryInterface::class);
        $this->reviewFactory = new ReviewFactory($this->factoryMock);
    }

    public function testItImplementsFactoryInterface(): void
    {
        self::assertInstanceOf(FactoryInterface::class, $this->reviewFactory);
    }

    public function testItImplementsReviewFactoryInterface(): void
    {
        self::assertInstanceOf(ReviewFactoryInterface::class, $this->reviewFactory);
    }

    public function testCreatingANewReview(): void
    {
        /** @var ReviewInterface|MockObject $reviewMock */
        $reviewMock = $this->createMock(ReviewInterface::class);

        $this->factoryMock->expects($this->once())->method('createNew')->willReturn($reviewMock);

        self::assertSame($reviewMock, $this->reviewFactory->createNew());
    }

    public function testCreatingAReviewWithSubject(): void
    {
        /** @var ReviewableInterface&MockObject $subjectMock */
        $subjectMock = $this->createMock(ReviewableInterface::class);

        /** @var ReviewInterface&MockObject $reviewMock */
        $reviewMock = $this->createMock(ReviewInterface::class);

        $this->factoryMock->expects($this->once())->method('createNew')->willReturn($reviewMock);

        $reviewMock->expects($this->once())->method('setReviewSubject')->with($subjectMock);

        $result = $this->reviewFactory->createForSubject($subjectMock);

        self::assertSame($reviewMock, $result);
    }

    public function testCreatingAReviewWithSubjectAndReviewer(): void
    {
        /** @var ReviewableInterface&MockObject $subjectMock */
        $subjectMock = $this->createMock(ReviewableInterface::class);

        /** @var ReviewInterface&MockObject $reviewMock */
        $reviewMock = $this->createMock(ReviewInterface::class);

        /** @var ReviewerInterface&MockObject $reviewerMock */
        $reviewerMock = $this->createMock(ReviewerInterface::class);

        $this->factoryMock->expects($this->once())->method('createNew')->willReturn($reviewMock);

        $reviewMock->expects($this->once())->method('setReviewSubject')->with($subjectMock);

        $reviewMock->expects($this->once())->method('setAuthor')->with($reviewerMock);

        $result = $this->reviewFactory->createForSubjectWithReviewer($subjectMock, $reviewerMock);

        self::assertSame($reviewMock, $result);
    }
}
