<?php
$path = "/media/sf_SharedDisk/Bill Laurance-Swift01-Prologue_ Fjords.mp3";
//$path = "/media/sf_SharedDisk/id3test.mp3";
//var_dump(id3_get_tag($path));


$x = new CMP3File($path);
var_dump($x);

class CMP3File
{
    const TITLE_LENGTH = 30;
    const ARTIST_LENGTH = 30;
    const ALBUM_LENGTH = 30;
    const YEAR_LENGTH = 4;
    const COMMENT_LENGTH = 30;
    const GENRE_LENGTH = 1;
    const ID3_DATA_LEN = 128;

    /** @var array  */
    private static $fieldOrder = [
        "title" => self::TITLE_LENGTH,
        "artist" => self::ARTIST_LENGTH,
        "album" => self::ALBUM_LENGTH,
        "year" => self::YEAR_LENGTH,
        "comment" => self::COMMENT_LENGTH,
        "genre" => self::GENRE_LENGTH,
    ];

    /** @var string */
    private $title;
    /** @var string  */
    private $artist;
    /** @var string  */
    private $album;
    /** @var string  */
    private $year;
    /** @var string  */
    private $comment;
    /** @var string  */
    private $genre;
    /** @var bool  */
    private $isID3 = false;

    const ID3TAG = 'TAG';

    public function __construct($file)
    {
        if (file_exists($file))
        {
            $id_start = filesize($file) - self::ID3_DATA_LEN;
            $fp = fopen($file, "r");
            if ($fp)
            {
                fseek($fp, $id_start);
                $tag = fread($fp, strlen(self::ID3TAG));
                if ($tag == self::ID3TAG)
                {
                    $this->isID3 = true;
                    $totalLen = strlen(self::ID3TAG);
                    foreach (self::$fieldOrder as $field => $length)
                    {
                        $totalLen+= $length;
                        $this->{$field} = fread($fp, $length);
                    }
                    if ($totalLen != self::ID3_DATA_LEN)
                    {
                        throw new Exception("Programming configuration error - unexpected field lengths ($totalLen)");
                    }
                }
                fclose($fp);
            }
        }
    }
} 
