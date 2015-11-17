<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 17/11/15
 * Time: 23:17
 */
namespace oconnedk\id3;

class CMP3FileTest extends \PHPUnit_Framework_TestCase
{

    public function testInvalidFileDoesntNeedID3Tags()
    {
        $file = new CMP3File("invalid file");
        $this->assertFalse($file->needsID3Info());
    }

    public function testAlbumAndArtistNameChosen()
    {

    }
} 