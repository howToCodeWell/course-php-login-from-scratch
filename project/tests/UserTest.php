<?php

declare(strict_types=1);
namespace Test;

use PHPUnit\Framework\TestCase;

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

    public function testGetUsernameWhenSet(): void
    {
        $userKey = 'user_1';
        $username = 'howtocodewell1';
        $_SESSION['user_key'] = $userKey;
        $this->assertSame($username, getUsername());
    }

    public function testGetUserWithEmptyCredentials(): void
    {
        $this->assertNull(getUser('', ''));
    }

    public function testGetUserWithIncorrectCredentials(): void
    {
        $this->assertNull(getUser('howtocodewell1', 'not-valid'));
    }

    public function testGetUserWithCorrectCredentials(): void
    {
        $this->assertSame('user_1', getUser('howtocodewell1', 'testHTCW'));
    }
}
