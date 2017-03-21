<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class ListUserCommand extends ContainerAwareCommand
{
    /**
     * Config of the command
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:list-users')

            // the short description shown while running "php bin/console list"
            ->setDescription('List users from DB')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to get users data from DB.')
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
        $table = new Table($output);
        $table
            ->setHeaders(array('User', 'Album', 'Photos'))
            ->setRows(array(
                //TODO get data from DB
            ))
        ;
        $table->render();
    }
}