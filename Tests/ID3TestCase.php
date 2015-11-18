<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 18/11/15
 * Time: 14:06
 */

namespace oconnedk\Tests;

class ID3TestCase extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    protected static $resourcePath = "";

    /**
     * @inheritdoc
     */
    public static function setUpBeforeClass()
    {
        self::$resourcePath = __DIR__."/Resources";
    }

} 