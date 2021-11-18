<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once dirname(__FILE__).'/../common.php';

class UserTest extends TestCase
{
    public function testGetUserKeyWhenNotSet(): void
    {
        $this->assertNull(getUserKey());
    }

    public function testGetUserKeyWhenSet(): void
    {
        $key = 'test_key';
        $_SESSION['user_key'] = $key;
        $this->assertSame($key, getUserKey());
    }

    public function testGetUserNameWhenNotSet(): void
    {
        $this->assertEmpty(getUsername());
    }

    public function testGetUserNameWhenSet(): void
    {
        $userKey = 'user_1';
        $username = 'howtocodewell1';
        $_SESSION['user_key'] = $userKey;
        $this->assertSame($username, getUsername());
    }
}

