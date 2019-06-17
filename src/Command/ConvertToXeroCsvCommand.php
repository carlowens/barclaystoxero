<?php

namespace App\Command;

use App\Model\ConverterServiceMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConvertToXeroCsvCommand extends Command
{
    protected static $defaultName = 'app:convertToXeroCsv';

    protected function configure()
    {
        $this
            ->setDescription('Converts Barclays Business CSV statements to Xero format for import')
            ->addArgument('pathToCSVs', InputArgument::OPTIONAL, 'Path where barlclays CSVs')
            ->addArgument('savePath', InputArgument::OPTIONAL, 'Save Xero formatted CSV')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $pathToCSVs = $input->getArgument('pathToCSVs');
        $pathToSave = $input->getArgument('pathToCSVs');

        if ($pathToCSVs) {
            $io->note(sprintf('You passed an argument: %s', $pathToCSVs));
        } else {
            $pathToCSVs = __DIR__. DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data';
            $io->note(sprintf('You did not pass an argument.  Using data directory: %s', $pathToCSVs));
        }

        if ($pathToSave) {
            $io->note(sprintf('You passed an argument: %s', $pathToSave));
        } else {
            $pathToSave = __DIR__. DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data';
            $io->note(sprintf('You did not pass an argument.  Using data directory: %s', $pathToSave));
        }

        $maker =new ConverterServiceMaker();

        $service = $maker->getConverterService();
        $filePath = $service->ConvertCsvs($pathToCSVs, $pathToSave);

        $io->success('Success!  File saved to: '.$filePath);
    }
}
