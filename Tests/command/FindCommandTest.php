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

    /** @var string */
    protected static $resourcePath = "";

    /**
     * @inheritdoc
     */
    public static function setUpBeforeClass()
    {
        self::$resourcePath = __DIR__."/../Resources";
    }

    /**
     * Positive test - test that files are found
     */
    public function testFind()
    {
        $commandTester = self::runFindCommand();
        $this->assertRegExp(self::FOUND_FILES_REGEXP, $commandTester->getDisplay());
    }

    /**
     * @expectedException \Exception
     */
    public function testFindForInvalidPath()
    {
        self::runFindCommand(['path' => '/invalid/path/']);
    }

    /**
     * @param array $args
     * @return CommandTester
     */
    public static function runFindCommand(array $args = [])
    {
        $defaultArgs = [
            'path' => self::$resourcePath
        ];
        $commandTester = self::createFindTester();
        $commandTester->execute(array_merge($defaultArgs, $args));
        return $commandTester;
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
