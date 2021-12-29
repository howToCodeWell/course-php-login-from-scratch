<?php

declare(strict_types=1);
namespace Test;

use PHPUnit\Framework\TestCase;

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
