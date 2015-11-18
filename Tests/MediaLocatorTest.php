<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 18/11/15
 * Time: 00:01
 */
namespace oconnedk\Tests;

use oconnedk\id3\MediaLocator;

class MediaLocatorTest extends ID3TestCase
{
    const INVALID_PATH = "INVALID/PATH";
    const MP3 = "mp3";

    /**
     * @expectedException \Exception
     */
    public function testInvalidPath()
    {
        MediaLocator::find(self::INVALID_PATH, self::MP3);
    }

    public function testValidPath()
    {
        $found = MediaLocator::find(self::$resourcePath, self::MP3);
        $this->assertGreaterThan(0, count($found));
    }
}
