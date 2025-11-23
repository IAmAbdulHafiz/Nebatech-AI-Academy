<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Nebatech\Core\Database;

class DatabaseTest extends TestCase
{
    public function testValidateTableNameThrowsExceptionForInvalidTable()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        // Use reflection to access protected method
        $reflection = new \ReflectionClass(Database::class);
        $method = $reflection->getMethod('validateTableName');
        $method->setAccessible(true);
        
        $method->invoke(null, 'invalid_table_name');
    }

    public function testValidateTableNameAcceptsValidTable()
    {
        $reflection = new \ReflectionClass(Database::class);
        $method = $reflection->getMethod('validateTableName');
        $method->setAccessible(true);
        
        // Should not throw exception
        $method->invoke(null, 'users');
        $method->invoke(null, 'courses');
        
        $this->assertTrue(true); // If we get here, validation passed
    }
}
