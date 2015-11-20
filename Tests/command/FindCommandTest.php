<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 20/11/15
 * Time: 15:22
 */

namespace oconnedk\Tests\command;

use oconnedk\id3\command\FindCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class FindCommandTest extends \PHPUnit_Framework_TestCase
{
    const FOUND_FILES_REGEXP = '/These files need ID3 tags.*/';
    const CONCISE_OPTION = '--concise';

    /** @var string */
    protected static $resourcePath = "";
    /** @var array */
    private static $defaultArgs = [];
    /** @var array  */
    private static $expectedFolders = [
        "Untagged Artist Name",
        "MP3 Tests"
    ];
    /** @var array  */
    private static $expectedFiles = [
        "Artist Name - Track 1.mp3",
        "Artist Name - Track 2.mp3",
        "temp.emptytags.mp3",
        "temp.withtags.mp3"
    ];

    /**
     * @inheritdoc
     */
    public static function setUpBeforeClass()
    {
        self::$resourcePath = __DIR__."/../Resources";
        self::$defaultArgs = [
            'path' => self::$resourcePath
        ];
    }

    /**
     * Negative test - no path
     * @expectedException \Exception
     */
    public function testNoPath()
    {
        self::runFindCommand([]);
    }

    /**
     * Negative test
     * @expectedException \Exception
     */
    public function testFindForInvalidPath()
    {
        self::runFindCommand(['path' => '/invalid/path/']);
    }

    /**
     * Positive test - test that files are found
     */
    public function testFind()
    {
        $commandTester = self::runFindCommand(self::$defaultArgs);
        $this->assertRegExp(self::FOUND_FILES_REGEXP, $commandTester->getDisplay());
        // Should find the files under each of those folders
        $this->assertMatchesThese(self::$expectedFiles, $commandTester);
    }

    /**
     * Positive test - test that files are found
     */
    public function testFindConcise()
    {
        $commandTester = self::runFindCommand(array_merge(self::$defaultArgs, [self::CONCISE_OPTION => true]));
        $this->assertRegExp(self::FOUND_FILES_REGEXP, $commandTester->getDisplay());
        // Should find the expected folders
        $this->assertMatchesThese(self::$expectedFolders, $commandTester);
    }

    /**
     * @param array $args
     * @return CommandTester
     */
    public static function runFindCommand(array $args = [])
    {
        $commandTester = self::createFindTester();
        $commandTester->execute($args);
        return $commandTester;
    }

    /**
     * Check that the supplied filenames (and only those) are contained within the output of the test
     * @param string[] $fileNames
     * @param CommandTester $tester
     * @return int
     */
    private function assertMatchesThese(array $fileNames, CommandTester $tester)
    {
        $this->assertNotCount(0, $fileNames);   // This would be a programming error on the part of the test writer
        $display = $tester->getDisplay(true);
        $matchCount = $display ? substr_count($display, PHP_EOL) - 1 : 0;
        $this->assertEquals($matchCount, count($fileNames));
        foreach ($fileNames as $fileName) {
            $this->assertContains($fileName, $display);
        }
    }

    /**
     * @return CommandTester
     */
    private static function createFindTester()
    {
        $application = new Application();
        $application->add(new FindCommand());
        $command = $application->find(FindCommand::COMMAND_NAME);
        return new CommandTester($command);
    }
}
