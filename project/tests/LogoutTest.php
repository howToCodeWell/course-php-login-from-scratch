<?php

declare(strict_types=1);
namespace Test;

use PHPUnit\Framework\TestCase;

class LogoutTest extends TestCase
{
    public function testLogout(): void
    {
        $_SESSION['user_key'] = 'test';
        logout();
        $this->assertEmpty($_SESSION);
    }
}
