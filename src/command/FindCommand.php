<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 19/11/15
 * Time: 17:13
 */

namespace oconnedk\id3\command;

use oconnedk\id3\CMP3File;
use oconnedk\id3\MediaLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class FindCommand extends Command
{
    const COMMAND_NAME = 'find';
    const PATH_ARGUMENT = 'path';
    const FIND_MEDIATYPE = 'mp3';

    protected function configure()
    {
        $cmd = self::COMMAND_NAME;
        $this->setName($cmd)
            ->setDescription('Finds media requiring ID3 tags in the specified path')
            ->setDefinition([
                new InputArgument(
                    self::PATH_ARGUMENT,
                    InputArgument::REQUIRED,
                    'The directory containing your media',
                    null
                ),
            ])
            ->setHelp(<<<EOT
The <info>$cmd</info> command locates any albums in your specified media directory requiring ID3 tags
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $needingID3Tags = [];
        foreach (MediaLocator::find($input->getArgument(self::PATH_ARGUMENT), self::FIND_MEDIATYPE) as $mediaEntry) {
            $path = $mediaEntry->getPath();
            $file = new CMP3File($path);
            if ($file->needsID3Info()) {
                $needingID3Tags[] = $path;
            }
        }
        if ($needingID3Tags) {
            $output->writeln("These files need ID3 tags:");
            $output->writeln(implode(PHP_EOL, $needingID3Tags));
        }
    }
}
