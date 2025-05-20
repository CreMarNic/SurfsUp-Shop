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

namespace Tests\Sylius\Bundle\LocaleBundle\Context;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Sylius\Bundle\LocaleBundle\Context\RequestBasedLocaleContext;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Context\LocaleNotFoundException;
use Sylius\Component\Locale\Provider\LocaleProviderInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class RequestBasedLocaleContextTest extends TestCase
{
    /**
     * @var RequestStack|MockObject
     */
    private MockObject $requestStackMock;
    /**
     * @var LocaleProviderInterface|MockObject
     */
    private MockObject $localeProviderMock;
    private RequestBasedLocaleContext $requestBasedLocaleContext;
    protected function setUp(): void
    {
        $this->requestStackMock = $this->createMock(RequestStack::class);
        $this->localeProviderMock = $this->createMock(LocaleProviderInterface::class);
        $this->requestBasedLocaleContext = new RequestBasedLocaleContext($this->requestStackMock, $this->localeProviderMock);
    }

    public function testALocaleContext(): void
    {
        $this->assertInstanceOf(LocaleContextInterface::class, $this->requestBasedLocaleContext);
    }

    public function testThrowsLocaleNotFoundExceptionIfMasterRequestIsNotFound(): void
    {
        $this->requestStackMock->expects($this->once())->method('getMainRequest')->willReturn(null);
        $this->expectException(LocaleNotFoundException::class);
        $this->requestBasedLocaleContext->getLocaleCode();
    }

    public function testThrowsLocaleNotFoundExceptionIfMasterRequestDoesNotHaveLocaleAttribute(): void
    {
        /** @var Request|MockObject $requestMock */
        $requestMock = $this->createMock(Request::class);
        $this->requestStackMock->expects($this->once())->method('getMainRequest')->willReturn($requestMock);
        $requestMock->attributes = new ParameterBag();
        $this->expectException(LocaleNotFoundException::class);
        $this->requestBasedLocaleContext->getLocaleCode();
    }

    public function testThrowsLocaleNotFoundExceptionIfMasterRequestLocaleCodeIsNotAmongAvailableOnes(): void
    {
        /** @var Request|MockObject $requestMock */
        $requestMock = $this->createMock(Request::class);
        $this->requestStackMock->expects($this->once())->method('getMainRequest')->willReturn($requestMock);
        $requestMock->attributes = new ParameterBag(['_locale' => 'en_US']);
        $this->localeProviderMock->expects($this->once())->method('getAvailableLocalesCodes')->willReturn(['pl_PL', 'de_DE']);
        $this->expectException(LocaleNotFoundException::class);
        $this->requestBasedLocaleContext->getLocaleCode();
    }

    public function testReturnsMasterRequestLocaleCode(): void
    {
        /** @var Request|MockObject $requestMock */
        $requestMock = $this->createMock(Request::class);
        $this->requestStackMock->expects($this->once())->method('getMainRequest')->willReturn($requestMock);
        $requestMock->attributes = new ParameterBag(['_locale' => 'pl_PL']);
        $this->localeProviderMock->expects($this->once())->method('getAvailableLocalesCodes')->willReturn(['pl_PL', 'de_DE']);
        $this->assertSame('pl_PL', $this->requestBasedLocaleContext->getLocaleCode());
    }
}
