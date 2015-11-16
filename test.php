<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 16/11/15
 * Time: 17:40
 */

require_once(__DIR__."/CMP3File.php");

findFiles("/media/sf_SharedDisk/mp3/", "mp3");

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
        $file = current($match);
        $dir = dirname($file);
        $parDir = dirname($dir);
        $dirName = str_replace($parDir, "", $dir);
        var_dump($file, $dirName);
    }
}


$paths = [
    "/media/sf_SharedDisk/mp3/Bill Laurance-Swift01-Prologue_ Fjords.mp3",
    "/media/sf_SharedDisk/mp3/id3test.mp3"
];
foreach ($paths as $path)
{
    $x = new CMP3File($path);
    $x->set(CMP3File::TITLE, "Title");
    $x->set(CMP3File::ARTIST, "Artist");
    $x->set(CMP3File::ALBUM, "Album");
    $x->set(CMP3File::YEAR, "Year");
    $x->set(CMP3File::COMMENT, "Comment");
    var_dump($x);
}
