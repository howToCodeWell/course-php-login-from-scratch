<?php

declare(strict_types=1);
namespace Test;

use PHPUnit\Framework\TestCase;

//require_once dirname(__FILE__) . '/../common.php';

class LogoutTest extends TestCase
{
    public function testLogout(): void
    {
        $_SESSION['user_key'] = 'test';
        logout();
        $this->assertEmpty($_SESSION);
    }
}
