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

    public function testAlbumAndArtistNameChosen()
    {

    }
} 