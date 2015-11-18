<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 18/11/15
 * Time: 00:01
 */
namespace oconnedk\id3;

class MediaLocatorTest extends \PHPUnit_Framework_TestCase
{
    const INVALID_PATH = "INVALID/PATH";
    const MP3 = "mp3";

    private static $resourcePath = "";

    public static function setUpBeforeClass()
    {
        self::$resourcePath = __DIR__."/Resources";
    }

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