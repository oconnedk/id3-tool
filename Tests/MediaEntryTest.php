<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 17/11/15
 * Time: 23:25
 */

namespace oconnedk\Tests;

use oconnedk\id3\MediaEntry;

class MediaEntryTest extends ID3TestCase
{
    public function testInferArtistAndTrackName()
    {
        $media = new MediaEntry("/artist/track.mp3");
        $this->assertTrue($media->getArtistName() == "artist");
        $this->assertTrue($media->getTrackName() == "track");
    }

    public function testAlbumNameOverride()
    {
        $media = new MediaEntry("/parent/ignore - track.mp3");
        $this->assertTrue(
            $media->getArtistName() == "parent",
            "Expected ".$media->getArtistName()." to equal 'parent'"
        );
        $this->assertTrue(
            $media->getTrackName() == "track",
            "Expected ".$media->getTrackName()." to equal 'track'"
        );
    }
}
