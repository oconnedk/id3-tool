<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 17/11/15
 * Time: 23:57
 */

namespace oconnedk\id3;

interface MediaAware
{
    /**
     * @return string
     */
    public function getArtistName();

    /**
     * @return string
     */
    public function getDir();

    /**
     * @return string
     */
    public function getFilename();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getTrackName();
}
