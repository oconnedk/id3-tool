<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 16/11/15
 * Time: 17:40
 */

require_once(__DIR__."/CMP3File.php");

findFiles("/media/sf_SharedDisk/mp3/", str_replace(".", "", MediaEntry::MEDIA_TYPE_EXTENSION));

/**
 * @param string $path
 * @param string $pattern
 */
function findFiles($path, $extension)
{
    if (!dir($path))
    {
        throw new Exception("$path is not a directory!");
    }
    $dirIter = new RecursiveDirectoryIterator($path);
    $mainIter = new RecursiveIteratorIterator($dirIter);
    foreach (new RegexIterator($mainIter, '/^.+\.'.$extension.'$/i', RecursiveRegexIterator::GET_MATCH) as $match)
    {
        $file = new MediaEntry(current($match));
        var_dump($file);
    }
}


$paths = [
    "/media/sf_SharedDisk/mp3/Bill Laurance-Swift01-Prologue_ Fjords.mp3",
    "/media/sf_SharedDisk/mp3/id3test.mp3"
];
foreach ($paths as $path)
{
    $x = new CMP3File($path);
/*    $x->set(CMP3File::TITLE, "Title");
    $x->set(CMP3File::ARTIST, "Artist");
    $x->set(CMP3File::ALBUM, "Album");
    $x->set(CMP3File::YEAR, "Year");
    $x->set(CMP3File::COMMENT, "Comment");
*/
    var_dump($x, "Needs ID3:", $x->needsID3Info());
}


class MediaEntry
{
    const MEDIA_TYPE_EXTENSION = '.mp3';
    const NAME_SEPARATOR = ' - ';
    /** @var string */
    private $dir;
    /** @var string  */
    private $filename;

    /** @var string  */
    private $artistName = "";
    /** @var string  */
    private $trackName = "";


    public function __construct($path)
    {
        $dir = dirname($path);      // Find dir of path
        $parDir = dirname($dir);    // Find parent of dir
        $this->dir = basename(str_replace($parDir, "", $dir));  // Get rid of the "parent" part of the pathname
        $this->filename = basename($path);
        $this->inferNames();
    }

    private function inferNames()
    {
        $parts = explode(self::NAME_SEPARATOR, $this->dir);
        if (count($parts) == 1)
        {
            // Folder name is probably just artist name...
            $this->artistName = $this->dir;
        }
        else
        {
            $this->artistName = $parts[0];
        }
        $parts = explode(self::NAME_SEPARATOR, basename($this->filename, self::MEDIA_TYPE_EXTENSION));
        if (count($parts) == 1)
        {
            // Folder name is probably just artist name...
            $this->trackName = $parts[0];
        }
        else if (count($parts) > 1)
        {
            // Use last separator for track name - hit and miss, maybe...
            $this->trackName = $parts[count($parts) - 1];
        }
    }
}