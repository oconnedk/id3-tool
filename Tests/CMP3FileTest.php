<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 17/11/15
 * Time: 23:17
 */
namespace oconnedk\Tests;

use oconnedk\id3\CMP3File;

class CMP3FileTest extends ID3TestCase
{

    public function testInvalidFileDoesntNeedID3Tags()
    {
        $file = new CMP3File("invalid file");
        $this->assertFalse($file->needsID3Info());
    }

    public function testHasNoTags()
    {
        $file = self::getMP3TestFile("temp.notags.mp3");
        $this->assertFalse($file->isID3Tagged());
    }

    public function testHasTags()
    {
        $file = self::getMP3TestFile("temp.withtags.mp3");
        $this->assertTrue($file->isID3Tagged());
    }

    /**
     * Test that only mp3 files which have a tag header, but have blank info are deemed "needing tags"
     */
    public function testNeedsTags()
    {
        $file = self::getMP3TestFile("temp.emptytags.mp3");
        $this->assertTrue($file->needsID3Info());
    }

    /**
     * @param $filename
     * @return CMP3File
     */
    private static function getMP3TestFile($filename)
    {
        return new CMP3File(self::$resourcePath."/mp3/MP3 Tests/$filename");
    }
}
