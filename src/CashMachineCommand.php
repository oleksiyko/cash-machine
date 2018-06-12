<?php
namespace CashMachine;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use \Exception;

class CashMachineCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('CashMachine')
            ->setDescription('Command to emulate of withdraw cash from cash machine')
            ->addOption(
                'amount',
                null,
                InputOption::VALUE_REQUIRED,
                'Amount of cash to withdraw'
            )
        ;
    }
    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $amount = intval($input->getOption('amount'));
        $cashMachine = new InfiniteCashMachine();
        try {
            $withdrawnNotes = $cashMachine->withdraw($amount);
            $output->writeln(sprintf('Withdrawn notes: %s', implode(', ', $withdrawnNotes)));
        } catch (Exception $e) {
            $output->writeln(sprintf('ERROR: %s', $e->getMessage()));
        }
    }
}