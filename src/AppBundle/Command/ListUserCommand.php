<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;

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
        $users = $this->getContainer()->get('user_controller')->index();
        $table->setHeaders(array('VK ID', 'User', 'Albums', 'Photo'));
        $rows_array = array();
        // Get users
        foreach ($users as $user){
            // Get albums
            $albums = $user->getAlbums();
            foreach ($albums as $album){
                // Get photos
                $photos = $album->getPhotos();
                foreach ($photos as $photo){
                    // Set table row
                    $rows_array[] = array($user->getVkId(), $user->getName() . ' ' . $user->getLastName(), $album->getTitle(), $photo->getSrc());
                }
            }
        }
        $table->setRows($rows_array);
        $table->render();
    }
}