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

namespace Tests\Sylius\Component\Product\Model;

use PHPUnit\Framework\MockObject\MockObject;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Product\Model\ProductOption;
use Sylius\Component\Product\Model\ProductOptionValue;

final class ProductOptionTest extends TestCase
{
    private ProductOption $productOption;

    protected function setUp(): void
    {
        $this->productOption = new ProductOption();
        $this->productOption->setCurrentLocale('en_US');
        $this->productOption->setFallbackLocale('en_US');
    }

    public function testHasNoIdByDefault(): void
    {
        $this->assertNull($this->productOption->getId());
    }

    public function testHasNoCodeByDefault(): void
    {
        $this->assertNull($this->productOption->getCode());
    }

    public function testItsCodeIsMutable(): void
    {
        $this->productOption->setCode('color');
        $this->assertSame('color', $this->productOption->getCode());
    }

    public function testHasNoNameByDefault(): void
    {
        $this->assertNull($this->productOption->getName());
    }

    public function testItsNameIsMutable(): void
    {
        $this->productOption->setName('Color');
        $this->assertSame('Color', $this->productOption->getName());
    }

    public function testHasNoPositionByDefault(): void
    {
        $this->assertNull($this->productOption->getPosition());
    }

    public function testItsPositionIsMutable(): void
    {
        $this->productOption->setPosition(10);
        $this->assertSame(10, $this->productOption->getPosition());
    }

    public function testHasAnEmptyCollectionOfValuesByDefault(): void
    {
        $this->assertInstanceOf(Collection::class, $this->productOption->getValues());
        $this->assertSame(0, $this->productOption->getValues()->count());
    }

    public function testCanHaveAValueAdded(): void
    {
        /** @var ProductOptionValue&MockObject $valueMock */
        $valueMock = $this->createMock(ProductOptionValue::class);
        $this->productOption->addValue($valueMock);
        $this->assertTrue($this->productOption->hasValue($valueMock));
    }

    public function testCanHaveALocaleRemoved(): void
    {
        /** @var ProductOptionValue&MockObject $valueMock */
        $valueMock = $this->createMock(ProductOptionValue::class);
        $this->productOption->addValue($valueMock);
        $this->productOption->removeValue($valueMock);
        $this->assertFalse($this->productOption->hasValue($valueMock));
    }
}
