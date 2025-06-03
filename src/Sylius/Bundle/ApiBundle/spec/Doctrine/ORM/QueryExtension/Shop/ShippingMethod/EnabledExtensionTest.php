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

namespace Tests\Sylius\Bundle\ApiBundle\Doctrine\ORM\QueryExtension\Shop\ShippingMethod;

use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;
use Sylius\Bundle\ApiBundle\Doctrine\ORM\QueryExtension\Shop\ShippingMethod\EnabledExtension;
use Sylius\Bundle\ApiBundle\SectionResolver\AdminApiSection;
use Sylius\Bundle\ApiBundle\SectionResolver\ShopApiSection;
use Sylius\Bundle\CoreBundle\SectionResolver\SectionProviderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;

final class EnabledExtensionTest extends TestCase
{
    /** @var SectionProviderInterface|MockObject */
    private MockObject $sectionProviderMock;

    private EnabledExtension $enabledExtension;

    protected function setUp(): void
    {
        $this->sectionProviderMock = $this->createMock(SectionProviderInterface::class);
        $this->enabledExtension = new EnabledExtension($this->sectionProviderMock);
    }

    public function testFiltersEnabledShippingMethod(): void
    {
        /** @var QueryBuilder|MockObject $queryBuilderMock */
        $queryBuilderMock = $this->createMock(QueryBuilder::class);
        /** @var QueryNameGeneratorInterface|MockObject $queryNameGeneratorMock */
        $queryNameGeneratorMock = $this->createMock(QueryNameGeneratorInterface::class);
        $this->sectionProviderMock->expects($this->once())->method('getSection')->willReturn(new ShopApiSection());
        $queryNameGeneratorMock->expects($this->once())->method('generateParameterName')->with('enabled')->willReturn('enabled');
        $queryBuilderMock->expects($this->once())->method('getRootAliases')->willReturn(['o']);
        $queryBuilderMock->expects($this->once())->method('andWhere')->with('o.enabled = :enabled')->willReturn($queryBuilderMock);
        $queryBuilderMock->expects($this->once())->method('setParameter')->with('enabled', true)->willReturn($queryBuilderMock);
        $this->enabledExtension->applyToItem(
            $queryBuilderMock,
            $queryNameGeneratorMock,
            ShippingMethodInterface::class,
            [],
            new Get(),
        );
    }

    public function testFiltersEnabledShippingMethods(): void
    {
        /** @var QueryBuilder|MockObject $queryBuilderMock */
        $queryBuilderMock = $this->createMock(QueryBuilder::class);
        /** @var QueryNameGeneratorInterface|MockObject $queryNameGeneratorMock */
        $queryNameGeneratorMock = $this->createMock(QueryNameGeneratorInterface::class);
        $this->sectionProviderMock->expects($this->once())->method('getSection')->willReturn(new ShopApiSection());
        $queryNameGeneratorMock->expects($this->once())->method('generateParameterName')->with('enabled')->willReturn('enabled');
        $queryBuilderMock->expects($this->once())->method('getRootAliases')->willReturn(['o']);
        $queryBuilderMock->expects($this->once())->method('andWhere')->with('o.enabled = :enabled')->willReturn($queryBuilderMock);
        $queryBuilderMock->expects($this->once())->method('setParameter')->with('enabled', true)->willReturn($queryBuilderMock);
        $this->enabledExtension->applyToCollection(
            $queryBuilderMock,
            $queryNameGeneratorMock,
            ShippingMethodInterface::class,
            new GetCollection(),
        );
    }

    public function testDoesNothingIfTheCurrentResourceIsNotAShippingMethodForItem(): void
    {
        /** @var QueryBuilder|MockObject $queryBuilderMock */
        $queryBuilderMock = $this->createMock(QueryBuilder::class);
        /** @var QueryNameGeneratorInterface|MockObject $queryNameGeneratorMock */
        $queryNameGeneratorMock = $this->createMock(QueryNameGeneratorInterface::class);
        $this->sectionProviderMock->expects($this->once())->method('getSection')->willReturn(new ShopApiSection());
        $queryBuilderMock->expects($this->never())->method('getRootAliases');
        $queryBuilderMock->expects($this->never())->method('andWhere');
        $this->enabledExtension->applyToItem($queryBuilderMock, $queryNameGeneratorMock, stdClass::class, [], new Get());
    }

    public function testDoesNothingIfTheCurrentResourceIsNotAShippingMethodForCollection(): void
    {
        /** @var QueryBuilder|MockObject $queryBuilderMock */
        $queryBuilderMock = $this->createMock(QueryBuilder::class);
        /** @var QueryNameGeneratorInterface|MockObject $queryNameGeneratorMock */
        $queryNameGeneratorMock = $this->createMock(QueryNameGeneratorInterface::class);
        $this->sectionProviderMock->expects($this->once())->method('getSection')->willReturn(new ShopApiSection());
        $queryBuilderMock->expects($this->never())->method('getRootAliases');
        $queryBuilderMock->expects($this->never())->method('andWhere');
        $this->enabledExtension->applyToCollection($queryBuilderMock, $queryNameGeneratorMock, stdClass::class, new GetCollection());
    }

    public function testDoesNothingIfTheCurrentSectionIsNotAShopForItem(): void
    {
        /** @var QueryBuilder|MockObject $queryBuilderMock */
        $queryBuilderMock = $this->createMock(QueryBuilder::class);
        /** @var QueryNameGeneratorInterface|MockObject $queryNameGeneratorMock */
        $queryNameGeneratorMock = $this->createMock(QueryNameGeneratorInterface::class);
        $this->sectionProviderMock->expects($this->once())->method('getSection')->willReturn(new AdminApiSection());
        $queryBuilderMock->expects($this->never())->method('getRootAliases');
        $queryBuilderMock->expects($this->never())->method('andWhere');
        $this->enabledExtension->applyToItem($queryBuilderMock, $queryNameGeneratorMock, ShippingMethodInterface::class, [], new Get());
    }

    public function testDoesNothingIfTheCurrentSectionIsNotAShopForCollection(): void
    {
        /** @var QueryBuilder|MockObject $queryBuilderMock */
        $queryBuilderMock = $this->createMock(QueryBuilder::class);
        /** @var QueryNameGeneratorInterface|MockObject $queryNameGeneratorMock */
        $queryNameGeneratorMock = $this->createMock(QueryNameGeneratorInterface::class);
        $this->sectionProviderMock->expects($this->once())->method('getSection')->willReturn(new AdminApiSection());
        $queryBuilderMock->expects($this->never())->method('getRootAliases');
        $queryBuilderMock->expects($this->never())->method('andWhere');
        $this->enabledExtension->applyToCollection($queryBuilderMock, $queryNameGeneratorMock, ShippingMethodInterface::class, new GetCollection());
    }
}
