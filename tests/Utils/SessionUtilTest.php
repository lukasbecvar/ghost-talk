<?php

namespace App\Tests\Utils;

use App\Utils\SessionUtil;
use App\Utils\SecurityUtil;
use PHPUnit\Framework\TestCase;

class SessionUtilTest extends TestCase
{
    public function testStartSession(): void
    {
        $securityUtilMock = $this->createMock(SecurityUtil::class);
        $sessionUtil = new SessionUtil($securityUtilMock);

        // simulate PHP_SESSION_NONE and ensure session_start is called
        $this->expectOutputString('');
        $sessionUtil->startSession();

        // simulate session already started and ensure session_start is not called
        $this->expectOutputString('');
        $sessionUtil->startSession();
    }

    public function testDestroySession(): void
    {
        $securityUtilMock = $this->createMock(SecurityUtil::class);
        $sessionUtil = new SessionUtil($securityUtilMock);

        // simulate session destruction
        $sessionUtil->destroySession();
        $this->assertEquals(PHP_SESSION_NONE, session_status());
    }

    public function testCheckSession(): void
    {
        $securityUtilMock = $this->createMock(SecurityUtil::class);
        $sessionUtil = new SessionUtil($securityUtilMock);

        // simulate session with session_name set
        $sessionUtil->setSession('example_session', 'some_value');
        $this->assertTrue($sessionUtil->checkSession('example_session'));

        // simulate session without session_name set
        $this->assertFalse($sessionUtil->checkSession('nonexistent_session'));
    }

    public function testSetAndGetSessionValue(): void
    {
        $securityUtilMock = $this->createMock(SecurityUtil::class);
        $sessionUtil = new SessionUtil($securityUtilMock);

        // mock encryptAes and decryptAes methods
        $securityUtilMock
            ->expects($this->any())
            ->method('encryptAes')
            ->willReturn('encrypted_value');

        $securityUtilMock
            ->expects($this->any())
            ->method('decryptAes')
            ->willReturn('decrypted_value');

        // test setSession
        $sessionUtil->setSession('example_session', 'original_value');
        $this->assertEquals('encrypted_value', $_SESSION['example_session']);

        // test getSessionValue
        $this->assertEquals('decrypted_value', $sessionUtil->getSessionValue('example_session'));
    }
}
