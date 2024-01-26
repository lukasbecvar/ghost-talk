<?php

namespace App\Tests\Utils;

use App\Utils\SecurityUtil;
use App\Managers\ErrorManager;
use PHPUnit\Framework\TestCase;

class SecurityUtilTest extends TestCase
{
    public function testEscapeString(): void
    {
        $errorManagerMock = $this->createMock(ErrorManager::class);
        $securityUtil = new SecurityUtil($errorManagerMock);

        // test escaping special characters
        $inputString = '<script>alert("Hello");</script>';
        $expectedOutput = '&lt;script&gt;alert(&quot;Hello&quot;);&lt;/script&gt;';
        $this->assertEquals($expectedOutput, $securityUtil->escapeString($inputString));
    }

    public function testHashValidate(): void
    {
        $errorManagerMock = $this->createMock(ErrorManager::class);
        $securityUtil = new SecurityUtil($errorManagerMock);

        // test valid hash validation
        $plainText = 'password123';
        $hash = password_hash($plainText, PASSWORD_BCRYPT);
        $this->assertTrue($securityUtil->hashValidate($plainText, $hash));

        // test invalid hash validation
        $invalidHash = 'invalid_hash';
        $this->assertFalse($securityUtil->hashValidate($plainText, $invalidHash));
    }

    public function testGenBcryptHash(): void
    {
        $errorManagerMock = $this->createMock(ErrorManager::class);
        $securityUtil = new SecurityUtil($errorManagerMock);

        // test generating bcrypt hash
        $plainText = 'password123';
        $cost = 12;
        $hash = $securityUtil->genBcryptHash($plainText, $cost);

        // ensure the generated hash is valid
        $this->assertTrue(password_verify($plainText, $hash));
    }
}
