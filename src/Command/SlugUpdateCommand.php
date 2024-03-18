<?php

namespace App\Command;

use App\Repository\SheetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsCommand(
    name: 'app:slug-update',
    description: 'Add a short description for your command',
)]
class SlugUpdateCommand extends Command
{
    public function __construct(
        private SheetRepository $sheetRepository,
        private SluggerInterface $slugger,
        private EntityManagerInterface $em
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        // $this
        //     ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        //     ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        // ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        $sheets = $this->sheetRepository->findAll();

        foreach ($sheets as $sheet) {
            if ($sheet->getSlug() == null)
            {
                $sheet->setSlug($this->slugger->slug($sheet->getName()));
                $this->em->persist($sheet);
            }
        }
        $this->em->flush();

        
        // $arg1 = $input->getArgument('arg1');
        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
