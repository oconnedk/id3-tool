<?php
$paths = [
    "/media/sf_SharedDisk/Bill Laurance-Swift01-Prologue_ Fjords.mp3",
    "/media/sf_SharedDisk/id3test.mp3"
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

class CMP3File
{
    const TITLE = "title";
    const ARTIST = "artist";
    const ALBUM = "album";
    const YEAR = "year";
    const COMMENT = "comment";
    const GENRE = "genre";

    const TITLE_LENGTH = 30;
    const ARTIST_LENGTH = 30;
    const ALBUM_LENGTH = 30;
    const YEAR_LENGTH = 4;
    const COMMENT_LENGTH = 30;
    const GENRE_LENGTH = 1;
    const ID3_DATA_LEN = 128;

    /**
     * Fields ordered as per ID3 header
     * @var array
     */
    private static $fieldConfig = [
        self::TITLE=>       self::TITLE_LENGTH,
        self::ARTIST =>     self::ARTIST_LENGTH,
        self::ALBUM =>      self::ALBUM_LENGTH,
        self::YEAR =>       self::YEAR_LENGTH,
        self::COMMENT =>    self::COMMENT_LENGTH,
        self::GENRE =>      self::GENRE_LENGTH,
    ];

    /** @var string  */
    private $path;
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

    public function __construct($path)
    {
        $this->path = $path;
        if (file_exists($path))
        {
            $id_start = filesize($path) - self::ID3_DATA_LEN;
            $fp = fopen($path, "r");
            if ($fp)
            {
                fseek($fp, $id_start);
                $tag = fread($fp, strlen(self::ID3TAG));
                if ($tag == self::ID3TAG)
                {
                    $this->isID3 = true;
                    $totalLen = strlen(self::ID3TAG);
                    foreach (self::$fieldConfig as $field => $length)
                    {
                        $totalLen+= $length;
                        $this->$field = fread($fp, $length);
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

    /**
     * @param string $attrib
     * @return mixed
     */
    public function get($attrib)
    {
        $this->assertHasProperty($attrib);
        return $this->$attrib;
    }

    /**
     * @param string $attrib
     * @param string $value
     * @throws Exception
     */
    public function set($attrib, $value)
    {
        $this->assertHasProperty($attrib);
        $maxLen = self::$fieldConfig[$attrib];
        $truncatedLen = isset($value[$maxLen]) ? $maxLen : strlen($value);
        $padLength = $maxLen - $truncatedLen;
        if ($padLength < 0)
        {
            throw new Exception("Programming error - negative padding length");
        }
        $padding = str_repeat("\000", $padLength);
        $this->$attrib = $value.$padding;
    }

    /**
     * Ensures the property is valid AND is allowed to be set!
     * @param string $attrib
     * @throws Exception
     */
    private function assertHasProperty($attrib)
    {
        if (!isset($this->$attrib) && isset(self::$fieldConfig[$attrib]))
        {
            throw new Exception("Tried to access invalid property ($attrib)");
        }
    }
} 
