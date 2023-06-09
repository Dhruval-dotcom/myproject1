<?php

namespace App\Command;

use App\Repository\VinylMixRepository;
use App\service\MixRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:talk-to-me',
    description: 'description from dhruval',
)]
class TalkToMeCommand extends Command
{
    public function __construct(private VinylMixRepository $mixRepository){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'Your name')
            ->addOption('yell', null, InputOption::VALUE_NONE, 'can i yell')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name') ?: 'whoever you are';
        $shoulyell = $input->getOption('yell');

        $msg = $shoulyell ? 'Hey '.$name : 'unknown';
        $io->success($msg);

        if($io->confirm(('Do You want a mix recommendation?'))){
            $mixes = $this -> mixRepository -> findAll();
            $mix = $mixes[array_rand($mixes)];
            $io -> note('I recommend '.$mix ->title );
        }

        return Command::SUCCESS;
    }
}
