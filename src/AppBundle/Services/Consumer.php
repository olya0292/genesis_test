<?php
namespace AppBundle\Services;

use Behat\Mink\Exception\Exception;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqplib\Message\AMQPMessage;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use AppBundle\Entity\Album;
use AppBundle\Entity\Photo;

/**
 * Class Consumer
 *
 * @package AppBundle\Services
 */
class Consumer implements ConsumerInterface
{
    /**
     * VK API instance
     *
     * @var
     */
    private $api;

    /**
     * Logger instance
     * @var
     */
    private $logger;

    /**
     * Doctrine Entity Manager
     *
     * @var EntityManager
     */
    private $em;

    /**
     * Consumer constructor.
     *
     * @param $api
     * @param $em
     */
    public function __construct($api, EntityManager $em, $logger){

        $this->api = $api;
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * Get message from queue, check how many albums user has, get photos from API.
     *
     * @param AMQPMessage $message
     * @return void
     */
    public function execute(AMQPMessage $message){
        try{
            // Get message from queue
            $body = json_decode(unserialize($message->body));

            // Make request to check user status and how many albums, photos user has
            $request = $this->api->call('users.get', ['user_ids' => $body->id, 'fields' => 'counters']);
            $vk_user = $request['response'][0];

            // If user active and has more than 0 photos and more then 0 albums
            if(!empty($vk_user['counters']) && ($vk_user['counters']['photos'] > 0 || $vk_user['counters']['albums'] > 0)){

                // Check if user already exist
                $user = $this->em->getRepository('AppBundle:User')->findOneByVkId($body->id);

                // If not, save user to DB
                if(empty($user)){
                    $this->_save_user($vk_user);
                    $this->em->flush();
                } else {
                    throw new \Exception('User already exists!');
                }
            } else {
                throw new \Exception('User does not has any photos or inactive!');
            }
        } catch (\Exception $exception){
            $this->logger->error(sprintf('Error: "%s"', $exception->getMessage()));
        }

    }

    /**
     * Save user to DB
     *
     * @param $vk_user
     */
    private function _save_user($vk_user){
        $user = new User();
        $user->setVkId($vk_user['id']);
        $user->setName($vk_user['first_name']);
        $user->setLastName($vk_user['last_name']);
        $this->em->persist($user);
        $this->_save_albums($vk_user['id'], $user);

    }

    /**
     * Save user's albums to DB
     *
     * @param $vk_id
     * @param $user
     */
    private function _save_albums($vk_id, $user){
        // Get user's albums
        $user_albums = $this->api->call('photos.getAlbums', ['owner_id' => $vk_id, 'need_system' => 1]);

        // Save to DB
        foreach ($user_albums['response']['items'] as $user_album){
            $album = new Album();
            $album->setTitle($user_album['title']);
            $album->setUser($user);
            $album->setVkAlbumId($user_album['id']);
            $this->em->persist($album);

            // Get album's photos
            $this->_save_photos($vk_id, $user, $album);
        }
    }

    /**
     * Save album's photo to DB
     *
     * @param $vk_id
     * @param $user
     * @param $album
     */
    private function _save_photos($vk_id, $user, $album){

        // Get photos from API
        $album_photos = $this->api->call('photos.get', ['owner_id' => $vk_id, 'album_id' => $album->getVkAlbumId(), 'photo_sizes' => 1]);

        // Save to photo to DB
        foreach ($album_photos['response']['items'] as $album_photo){
            $photo = new Photo();
            $photo->setUserId($user->getId());
            $photo->setAlbum($album);
            $photo->setSrc($album_photo['sizes'][0]['src']);
            $photo->setVkAlbumId($album_photo['album_id']);
            $this->em->persist($photo);
        }
    }
}