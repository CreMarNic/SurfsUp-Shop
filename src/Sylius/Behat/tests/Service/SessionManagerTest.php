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

namespace Tests\Sylius\Behat\Service;

use Behat\Mink\Mink;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Behat\Service\SecurityServiceInterface;
use Sylius\Behat\Service\SessionManager;
use Sylius\Behat\Service\SessionManagerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class SessionManagerTest extends TestCase
{
    private Mink&MockObject $mink;

    private MockObject&SharedStorageInterface $sharedStorage;

    private MockObject&SecurityServiceInterface $securityService;

    private SessionManager $sessionManager;

    protected function setUp(): void
    {
        $this->mink = $this->createMock(Mink::class);
        $this->sharedStorage = $this->createMock(SharedStorageInterface::class);
        $this->securityService = $this->createMock(SecurityServiceInterface::class);

        $this->sessionManager = new SessionManager($this->mink, $this->sharedStorage, $this->securityService);
    }

    public function testImplementsSessionServiceInterface(): void
    {
        $this->assertInstanceOf(SessionManagerInterface::class, $this->sessionManager);
    }

    public function testChangesSessionAndDoesNotRestoreSessionTokenIfSessionWasNotCalledBefore(): void
    {
        /** @var TokenInterface&MockObject $token */
        $token = $this->createMock(TokenInterface::class);

        $setCount = $this->exactly(2);
        $this->sharedStorage
            ->expects($setCount)
            ->method('set')
            ->willReturnCallback(function (string $key, mixed $value) use ($setCount, $token) {
                if ($setCount->numberOfInvocations() === 1) {
                    $this->assertSame($key, 'behat_previous_session_name', 'default_session');
                    $this->assertSame($value, 'default_session');
                }
                if ($setCount->numberOfInvocations() === 2) {
                    $this->assertSame($key, 'behat_previous_session_token_default_session', 'default_session');
                    $this->assertSame($value, $token);
                }
            })
        ;

        $this->sharedStorage
            ->expects($this->once())
            ->method('has')
            ->with('behat_previous_session_token_chrome_headless_second_session')
            ->willReturn(false)
        ;

        $this->mink->expects($this->once())->method('getDefaultSessionName')->willReturn('default_session');
        $this->mink->expects($this->once())->method('setDefaultSessionName')->with('chrome_headless_second_session');
        $this->mink->expects($this->once())->method('restartSessions');

        $this->securityService->expects($this->once())->method('getCurrentToken')->willReturn($token);
        $this->securityService->expects($this->never())->method('restoreToken');

        $this->sessionManager->changeSession();
    }

    public function testChangesSessionAndRestoresSessionTokenIfSessionWasCalledBefore(): void
    {
        /** @var TokenInterface&MockObject $token */
        $token = $this->createMock(TokenInterface::class);
        /** @var TokenInterface&MockObject $previousToken */
        $previousToken = $this->createMock(TokenInterface::class);

        $this->mink->expects($this->once())->method('getDefaultSessionName')->willReturn('default_session');
        $this->securityService->expects($this->once())->method('getCurrentToken')->willReturn($token);

        $setCount = $this->exactly(2);
        $this->sharedStorage
            ->expects($setCount)
            ->method('set')
            ->willReturnCallback(function (string $key, mixed $value) use ($setCount, $token) {
                if ($setCount->numberOfInvocations() === 1) {
                    $this->assertSame($key, 'behat_previous_session_name', 'default_session');
                    $this->assertSame($value, 'default_session');
                }
                if ($setCount->numberOfInvocations() === 2) {
                    $this->assertSame($key, 'behat_previous_session_token_default_session', 'default_session');
                    $this->assertSame($value, $token);
                }
            })
        ;

        $this->mink->expects($this->once())->method('setDefaultSessionName')->with('chrome_headless_second_session');
        $this->mink->expects($this->once())->method('restartSessions');
        $this->sharedStorage
            ->expects($this->once())
            ->method('has')
            ->with('behat_previous_session_token_chrome_headless_second_session')
            ->willReturn(true)
        ;
        $this->sharedStorage
            ->expects($this->once())
            ->method('get')
            ->with('behat_previous_session_token_chrome_headless_second_session')
            ->willReturn($previousToken)
        ;
        $this->securityService->expects($this->once())->method('restoreToken')->with($previousToken);

        $this->sessionManager->changeSession();
    }

    public function testRestoresSessionAndToken(): void
    {
        /** @var TokenInterface&MockObject $token */
        $token = $this->createMock(TokenInterface::class);
        /** @var TokenInterface&MockObject $defaultToken */
        $defaultToken = $this->createMock(TokenInterface::class);

        $this->sharedStorage
            ->expects($this->exactly(2))
            ->method('has')
            ->willReturnCallback(function (string $key): bool {
                return match ($key) {
                    'behat_previous_session_name' => true,
                    'behat_previous_session_token_previous_session' => true,
                    default => throw new \UnhandledMatchError(),
                };
            })
        ;

        $this->sharedStorage
            ->expects($this->exactly(2))
            ->method('get')
            ->willReturnCallback(function (string $key) use ($token): mixed {
                return match ($key) {
                    'behat_previous_session_name' => 'previous_session',
                    'behat_previous_session_token_previous_session' => $token,
                    default => throw new \UnhandledMatchError(),
                };
            })
        ;

        $setCount = $this->exactly(2);
        $this->sharedStorage
            ->expects($setCount)
            ->method('set')
            ->willReturnCallback(function (string $key, mixed $value) use ($setCount, $defaultToken) {
                if ($setCount->numberOfInvocations() === 1) {
                    $this->assertSame($key, 'behat_previous_session_name', 'default_session');
                    $this->assertSame($value, 'default_session');
                }
                if ($setCount->numberOfInvocations() === 2) {
                    $this->assertSame($key, 'behat_previous_session_token_default_session', 'default_session');
                    $this->assertSame($value, $defaultToken);
                }
            })
        ;

        $this->mink->expects($this->once())->method('getDefaultSessionName')->willReturn('default_session');
        $this->mink->expects($this->once())->method('setDefaultSessionName')->with('previous_session');
        $this->mink->expects($this->once())->method('restartSessions');

        $this->securityService->expects($this->once())->method('getCurrentToken')->willReturn($defaultToken);
        $this->securityService->expects($this->once())->method('restoreToken')->with($token);

        $this->sessionManager->restorePreviousSession();
    }

    public function testDoesNotRestoreSessionAndTokenIfPreviousSessionWasNeverCalled(): void
    {
        /** @var TokenInterface&MockObject $token */
        $token = $this->createMock(TokenInterface::class);

        $this->sharedStorage
            ->expects($this->once())
            ->method('has')
            ->with('behat_previous_session_name')
            ->willReturn(false)
        ;
        $this->sharedStorage->expects($this->never())->method('set')->with('behat_previous_session_name', 'default_session');

        $this->mink->expects($this->never())->method('getDefaultSessionName');
        $this->mink->expects($this->never())->method('setDefaultSessionName')->with('previous_session');
        $this->mink->expects($this->never())->method('restartSessions');

        $this->securityService->expects($this->never())->method('restoreToken')->with($token);

        $this->sessionManager->restorePreviousSession();
    }
}
