<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once dirname(__FILE__).'/../common.php';

class LoginTest extends TestCase
{
    public function testIsNotLoggedInByDefault(): void
    {
        $this->assertFalse(isLoggedIn());
    }

    public function testIsLoggedIn(): void
    {
        $_SESSION['user_key'] = 'foobar';
        $this->assertTrue(isLoggedIn());

        unset($_SESSION['user_key']);
    }
}

