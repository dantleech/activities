<?php

namespace Activities\Extension\Api\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSpecCommand extends Command
{
    public function configure(): void
    {
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return 0;
    }
}
