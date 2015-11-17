<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 16/11/15
 * Time: 17:40
 */
namespace oconnedk\id3;
$loader = require __DIR__.'/../vendor/autoload.php';

findFiles("/media/sf_SharedDisk/mp3/", str_replace(".", "", MediaEntry::MEDIA_TYPE_EXTENSION));

/**
 * @param string $path
 * @param string $pattern
 */
function findFiles($path, $extension)
{
    if (!dir($path))
    {
        throw new \Exception("$path is not a directory!");
    }
    $dirIter = new \RecursiveDirectoryIterator($path);
    $mainIter = new \RecursiveIteratorIterator($dirIter);
    foreach (new \RegexIterator($mainIter, '/^.+\.'.$extension.'$/i', \RecursiveRegexIterator::GET_MATCH) as $match)
    {
        $path = current($match);
        $file = new MediaEntry($path);
        //var_dump($file);
        $id3 = new CMP3File($path);

        print "$path - needs ID3? ".($id3->needsID3Info() ? "YES" : "NO")."\n";
        $trackNum = $id3->get(CMP3File::TRACK_NUMBER);
        if ($trackNum)
        {
            var_dump("TRACK NUM:", current(unpack("n", "\000$trackNum")), $trackNum);
        }

        if (!$id3->needsID3Info())
        {
            var_dump($id3->isID3Tagged(), $id3);
        }
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
    //var_dump($x, "Needs ID3:", $x->needsID3Info());
}