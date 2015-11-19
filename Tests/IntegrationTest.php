<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 18/11/15
 * Time: 17:33
 */

namespace oconnedk\Tests;

use oconnedk\id3\CMP3File;
use oconnedk\id3\MediaLocator;

/**
 * Put all the pieces together
 * Class IntegrationTest
 * @package oconnedk\Tests
 */
class IntegrationTest extends ID3TestCase
{
    public function testTaggedFiles()
    {
        $artistName = "Artist Name";
        $albumName = "Album";
        $trackPattern = "Track {NUM}";
        $albumPath = self::$resourcePath."/mp3/{$artistName}";
        $trackNum = 1;
        foreach (MediaLocator::find($albumPath, "mp3") as $mediaEntry) {
            $cmp3 = new CMP3File($mediaEntry->getPath());
            $this->assertTrue($cmp3->isID3Tagged());    // The files *are* ID3 tagged
            $this->assertEquals($mediaEntry->getArtistName(), $artistName);
            $expectedTrackName = str_replace("{NUM}", $trackNum, $trackPattern);
            $this->assertEquals($mediaEntry->getTrackName(), $expectedTrackName);
            // The files also have ID3 tags within them - let's check they are what's expected
            $checks = [
                CMP3File::ARTIST => $artistName,
                CMP3File::ALBUM => $albumName,
                CMP3File::TITLE => $expectedTrackName,
            ];
            foreach ($checks as $tag => $expected) {
                $this->assertEquals(trim($cmp3->get($tag)), $expected);
            }
            ++$trackNum;
        }
    }
}
