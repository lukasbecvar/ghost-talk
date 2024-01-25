<?php

namespace App\Tests\Utils;

use App\Utils\SiteUtil;
use PHPUnit\Framework\TestCase;

class SiteUtilTest extends TestCase
{
    public function testIsDevMode(): void
    {
        $siteUtil = new SiteUtil();

        // test when APP_DEBUG is 'true'
        $_ENV['APP_DEBUG'] = 'true';
        $this->assertTrue($siteUtil->isDevMode());

        // test when APP_DEBUG is not 'true'
        $_ENV['APP_DEBUG'] = 'false';
        $this->assertFalse($siteUtil->isDevMode());
    }

    public function testGetHttpHost(): void
    {
        $siteUtil = new SiteUtil();

        // test when HTTP_HOST is set
        $_SERVER['HTTP_HOST'] = 'example.com';
        $this->assertEquals('example.com', $siteUtil->getHttpHost());

        // test when HTTP_HOST is not set
        unset($_SERVER['HTTP_HOST']);
        $this->assertEquals('127.0.0.1', $siteUtil->getHttpHost());
    }

    public function testIsRunningLocalhost(): void
    {
        $siteUtil = new SiteUtil();

        // test when running on localhost
        $_SERVER['HTTP_HOST'] = 'localhost';
        $this->assertTrue($siteUtil->isRunningLocalhost());

        // test when running on localhost IP
        $_SERVER['HTTP_HOST'] = '127.0.0.1';
        $this->assertTrue($siteUtil->isRunningLocalhost());

        // test when running on private IP
        $_SERVER['HTTP_HOST'] = '10.0.0.93';
        $this->assertTrue($siteUtil->isRunningLocalhost());

        // test when not running on localhost
        $_SERVER['HTTP_HOST'] = 'example.com';
        $this->assertFalse($siteUtil->isRunningLocalhost());
    }

    public function testIsSsl(): void
    {
        $siteUtil = new SiteUtil();

        // test when HTTPS is set to 1
        $_SERVER['HTTPS'] = 1;
        $this->assertTrue($siteUtil->isSsl());

        // test when HTTPS is set to 'on'
        $_SERVER['HTTPS'] = 'on';
        $this->assertTrue($siteUtil->isSsl());

        // test when HTTPS is not set
        unset($_SERVER['HTTPS']);
        $this->assertFalse($siteUtil->isSsl());
    }
}
