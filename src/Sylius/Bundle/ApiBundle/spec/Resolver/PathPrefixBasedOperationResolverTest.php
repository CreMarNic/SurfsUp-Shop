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

namespace Tests\Sylius\Bundle\ApiBundle\Resolver;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\ApiBundle\Provider\PathPrefixProviderInterface;
use Sylius\Bundle\ApiBundle\Resolver\OperationResolverInterface;
use Sylius\Bundle\ApiBundle\Resolver\PathPrefixBasedOperationResolver;
use Sylius\Component\Addressing\Model\Country;

final class PathPrefixBasedOperationResolverTest extends TestCase
{
    /** @var ResourceMetadataCollectionFactoryInterface|MockObject */
    private MockObject $resourceMetadataCollectionFactoryMock;

    /** @var PathPrefixProviderInterface|MockObject */
    private MockObject $pathPrefixProviderMock;

    private PathPrefixBasedOperationResolver $pathPrefixBasedOperationResolver;

    protected function setUp(): void
    {
        $this->resourceMetadataCollectionFactoryMock = $this->createMock(ResourceMetadataCollectionFactoryInterface::class);
        $this->pathPrefixProviderMock = $this->createMock(PathPrefixProviderInterface::class);
        $this->pathPrefixBasedOperationResolver = new PathPrefixBasedOperationResolver($this->resourceMetadataCollectionFactoryMock, $this->pathPrefixProviderMock);
    }

    public function testImplementsTheOperationResolverInterface(): void
    {
        $this->assertInstanceOf(OperationResolverInterface::class, $this->pathPrefixBasedOperationResolver);
    }

    public function testReturnsGivenOperationIfItHasNoName(): void
    {
        /** @var Operation|MockObject $operationMock */
        $operationMock = $this->createMock(Operation::class);
        $operationMock->expects(self::once())->method('getName')->willReturn(null);
        self::assertSame($operationMock, $this->pathPrefixBasedOperationResolver
            ->resolve(Country::class, 'api/v2/shop/countries/CODE', $operationMock))
        ;
    }
}
