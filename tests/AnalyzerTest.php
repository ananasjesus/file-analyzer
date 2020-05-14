<?php

namespace File\Analyzer;

class AnalyzerTest extends \PHPUnit\Framework\TestCase
{
    public function testSimpleAnalyzeLine(): void
    {
        $config = require __DIR__ . '/test-configs/conf-local-simple.php';
        $result = (new Analyzer($config))->analyze();

        $this->assertEquals(1, $result['line']);
    }

    public function testSimpleAnalyzeLine2(): void
    {
        $config = require __DIR__ . '/test-configs/conf-local-simple2.php';
        $result = (new Analyzer($config))->analyze();

        $this->assertEquals(44619, $result['line']);
    }

    public function testSimpleAnalyzePosition(): void
    {
        $config = require __DIR__ . '/test-configs/conf-local-simple.php';
        $result = (new Analyzer($config))->analyze();

        $this->assertEquals(1, $result['position']);
    }

    public function testSimpleAnalyzePosition2(): void
    {
        $config = require __DIR__ . '/test-configs/conf-local-simple2.php';
        $result = (new Analyzer($config))->analyze();

        $this->assertEquals(7, $result['position']);
    }

    public function testLocalBigFilesizeError(): void
    {
        $config = require __DIR__ . '/test-configs/conf-local-filesize.php';
        $result = (new Analyzer($config))->analyze();

        $this->assertArrayHasKey('errors', $result);
    }

    public function testLocalMimetype(): void
    {
        $config = require __DIR__ . '/test-configs/conf-local-mimetype.php';
        $result = (new Analyzer($config))->analyze();

        $this->assertArrayNotHasKey('errors', $result);
    }

    public function testLocalBadMimetype(): void
    {
        $config = require __DIR__ . '/test-configs/conf-local-bad-mimetype.php';
        $result = (new Analyzer($config))->analyze();

        $this->assertArrayHasKey('errors', $result);
    }

    public function testRemoteLine(): void
    {
        $config = require __DIR__ . '/test-configs/conf-remote-size-mimetype.php';
        $result = (new Analyzer($config))->analyze();

        $this->assertEquals(3, $result['line']);
    }

    public function testRemotePosition(): void
    {
        $config = require __DIR__ . '/test-configs/conf-remote-size-mimetype.php';
        $result = (new Analyzer($config))->analyze();

        $this->assertEquals(12, $result['position']);
    }

    public function testRemoteBadMimetype(): void
    {
        $config = require __DIR__ . '/test-configs/conf-remote-size-bad-mimetype.php';
        $result = (new Analyzer($config))->analyze();

        $this->assertArrayHasKey('errors', $result);
    }
}