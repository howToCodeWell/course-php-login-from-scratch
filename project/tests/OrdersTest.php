<?php

declare(strict_types=1);
namespace Test;

use PHPUnit\Framework\TestCase;

//require_once dirname(__FILE__) . '/../common.php';

class OrdersTest extends TestCase
{
    public function testGetOrdersWithEmptyUsername(): void
    {
        $this->assertNull(getOrders(''));
    }

    public function testGetOrdersWithCorrectUsername(): void
    {
        $this->assertIsArray(getOrders('howtocodewell2'));
    }
}
