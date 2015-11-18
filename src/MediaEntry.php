<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 17/11/15
 * Time: 23:24
 */

namespace oconnedk\id3;

class MediaEntry implements MediaAware
{
    const MEDIA_TYPE_EXTENSION = '.mp3';
    const NAME_SEPARATOR = ' - ';
    /** @var string */
    private $dir;
    /** @var string  */
    private $filename;
    /** @var string */
    private $path;
    /** @var string  */
    private $artistName = "";
    /** @var string  */
    private $trackName = "";


    public function __construct($path)
    {
        $this->path = $path;
        $dir = dirname($path);      // Find dir of path
        $parDir = dirname($dir);    // Find parent of dir
        $this->dir = basename(str_replace($parDir, "", $dir));  // Get rid of the "parent" part of the pathname
        $this->filename = basename($path);
        $this->inferNames();
    }

    /**
     * @return string
     */
    public function getArtistName()
    {
        return $this->artistName;
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getTrackName()
    {
        return $this->trackName;
    }

    private function inferNames()
    {
        $parts = explode(self::NAME_SEPARATOR, $this->dir);
        if (count($parts) == 1) {
        // Folder name is probably just artist name...
            $this->artistName = $this->dir;
        } else {
            $this->artistName = $parts[0];
        }
        $parts = explode(self::NAME_SEPARATOR, basename($this->filename, self::MEDIA_TYPE_EXTENSION));
        if (count($parts) == 1) {
        // Folder name is probably just artist name...
            $this->trackName = $parts[0];
        } elseif (count($parts) > 1) {
        // Use last separator for track name - hit and miss, maybe...
            $this->trackName = $parts[count($parts) - 1];
        }
    }
}
