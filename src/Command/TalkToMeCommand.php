<?php

namespace App\Command;

use App\Service\MixRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:talk-to-me',
    description: 'A self aware command',
)]
class TalkToMeCommand extends Command
{
    public function __construct(private MixRepository $mixRepository)
    {
        parent::__construct();//the base class has a constructor that we need to call
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'Argument description/your name')
            ->addOption('yell', null, InputOption::VALUE_NONE, 'Option description/shall I yell?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name') ?: 'whoever u are';
        $shouldYell = $input->getOption('yell');

        $message = sprintf('hey %s', $name);
        if ($shouldYell){
            $message = strtoupper($message);
        }

        $io->success($message);

        if ($io->confirm('do u want a mix rec?')){
            $mixes = $this->mixRepository->findAll();
            $mix = $mixes[array_rand($mixes)];
            $io->note('i rec the mix: '.$mix['title']);
        }

        return Command::SUCCESS;
    }
}
