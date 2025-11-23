<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testEscapeFunction()
    {
        $this->assertEquals('&lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;', e('<script>alert("XSS")</script>'));
        $this->assertEquals('', e(null));
        $this->assertEquals('Test &amp; String', e('Test & String'));
    }

    public function testCsrfTokenGeneration()
    {
        session_start();
        $token1 = csrf_token();
        $token2 = csrf_token();
        
        $this->assertNotEmpty($token1);
        $this->assertEquals($token1, $token2); // Should be same in same session
        $this->assertEquals(64, strlen($token1)); // 32 bytes = 64 hex chars
    }

    public function testTimeAgoFunction()
    {
        $now = date('Y-m-d H:i:s');
        $this->assertEquals('Just now', timeAgo($now));
        
        $oneHourAgo = date('Y-m-d H:i:s', strtotime('-1 hour'));
        $this->assertEquals('1 hour ago', timeAgo($oneHourAgo));
        
        $twoDaysAgo = date('Y-m-d H:i:s', strtotime('-2 days'));
        $this->assertEquals('2 days ago', timeAgo($twoDaysAgo));
    }
}
