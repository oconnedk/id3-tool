<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 17/11/15
 * Time: 23:25
 */

namespace oconnedk\id3;

class MediaEntryTest extends \PHPUnit_Framework_TestCase
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
        $this->assertTrue($media->getArtistName() == "parent", "Expected ".$media->getArtistName()." to equal 'parent'");
        $this->assertTrue($media->getTrackName() == "track", "Expected ".$media->getTrackName()." to equal 'track'");
    }

}