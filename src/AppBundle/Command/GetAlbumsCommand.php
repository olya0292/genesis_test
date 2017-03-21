<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class GetAlbumsCommand
 * @package AppBundle\Command
 */
class GetAlbumsCommand extends ContainerAwareCommand
{
    /**
     * Config of the command
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:get-albums')

            // the short description shown while running "php bin/console list"
            ->setDescription('Get user\'s albums and photos from VK API')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to to get user\'s albums and photos from VK API by user ID.')

            // argument to the command
            ->addArgument('account_id', InputArgument::REQUIRED, 'Type user\'s ID')

            // option to set ID's source
            ->addOption(
                'src',
                null,
                InputOption::VALUE_REQUIRED,
                'Set your source for ID',
                'id'
            );
        ;
    }

    /**
     * Describe execution of the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $lastName = $input->getArgument('account_id');
        $src_type = 'id';
        if($input->getOption('src') === 'file'){
            $src_type = 'file';
        }
        $msg = array('id' => $id, 'src_type' => $src_type);
        $this->getContainer()->get('producer_service')->publish(json_encode($msg));
    }
}