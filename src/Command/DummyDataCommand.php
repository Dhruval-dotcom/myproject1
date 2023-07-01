<?php

namespace App\Command;

use App\DataFixtures\DummyData;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'dummy-data',
    description: 'Add a short description for your command',
)]
class DummyDataCommand extends Command
{

    public function __construct(private EntityManagerInterface $entityManager){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        
        $No_of_Songs = $io->ask('Enter Number Of Songs');
    
        while(intval($No_of_Songs)<=0){
            $io->warning('Value should be Integer and Greater than 0');
            $No_of_Songs = $io->ask('Enter Number Of Songs');
        }

        $No_of_Comment = $io->ask('Enter No Of Comment Answers');

        while(intval($No_of_Comment)<=0){
            $io->warning('Value should be Integer and Greater than 0');
            $No_of_Comment = $io->ask('Enter No Of Comment Answers');
        }

        $loader =new Loader();
        $loader->addFixture(new DummyData($No_of_Songs ,$No_of_Comment));

        $executor = new ORMExecutor($this->entityManager, new ORMPurger());
        $executor->execute($loader->getFixtures(),true); //appending data after fisrt iteration

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have succesfully created ' .$No_of_Songs. ' songs and ' .$No_of_Comment. ' Comment Answers');

        return Command::SUCCESS;
    }
}
