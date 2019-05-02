<?php

namespace App\Command;

use App\Generator\Generator;
use App\Set\Sets;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratePassword extends Command
{
    protected static $defaultName = 'generate-password';

    /** @var OutputInterface */
    private $output;

    protected function configure()
    {
        $this
            ->addArgument('sets', InputArgument::REQUIRED, 'The bit mask defining which sets to use')
            ->addOption('length', 'l', InputOption::VALUE_REQUIRED, 'Length of characters of the password to generate', 16)
            ->addOption('count', 'c', InputOption::VALUE_REQUIRED, 'Count of password to generate', 1)
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $setMask = $input->getArgument('sets');
        $passwordLength = $input->getOption('length');
        $count = $this->validateCount($input->getOption('count'));

        $generator = new Generator($this->getSets($setMask), $passwordLength);
        for ($i = 0; $i < $count; $i++) {
            $this->displayPassword($generator->generate());
        }

        $this->output->writeln('Thank to use "pwdgen" :)');
    }

    public function getHelp()
    {
        $help = 'List of available sets' . PHP_EOL . Sets::getSetsDescription() . PHP_EOL;
        $help .= 'For example if you want alphabetic characters upper AND lower case. 2 + 1 = 3, so just run "application.php 3" and voilà !';

        return $help;
    }

    private function displayPassword(string $password)
    {
        $this->output->writeln([
            '------------------------ Password generated ------------',
            $password,
            '--------------------------------------------------------',
        ]);
    }

    private function getSets($bitmask)
    {
        $bitmask = (int) $bitmask;
        if (0 >= $bitmask) {
            throw new InvalidOptionException('Setmask (-s) : Setmask MUST be strictly positive');
        }

        return Sets::getSets($bitmask);
    }

    private function validateCount($count)
    {
        if (0 >= $count) {
            throw new InvalidOptionException('Count (-c) : password to generate MUST be strictly positive');
        }

        if (!is_numeric($count)) {
            throw new InvalidOptionException('Count (-c) : MUST be numeric');
        }

        return (int) $count;
    }
}
