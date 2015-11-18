<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 17/11/15
 * Time: 23:54
 */

namespace oconnedk\id3;

class MediaLocator
{
    /**
     * @param string $path
     * @param string $extension
     * @param string $createClass - class name to create
     * @throws \Exception
     * @return MediaAware[]
     */
    public static function find($path, $extension, $createClass = "oconnedk\\id3\\MediaEntry")
    {
        $found = [];
        if (!is_dir($path)) {
            throw new \Exception("$path is not a directory!");
        }
        $dirIter = new \RecursiveDirectoryIterator($path);
        $mainIter = new \RecursiveIteratorIterator($dirIter);
        foreach (new \RegexIterator($mainIter, '/^.+\.'.$extension.'$/i', \RecursiveRegexIterator::GET_MATCH) as $match) {
            $found[] = new $createClass(current($match));
        }
        return $found;
    }
}
