<?php
namespace AppBundle\Services;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqplib\Message\AMQPMessage;

/**
 * Class Consumer
 *
 * @package AppBundle\Services
 */
class Consumer implements ConsumerInterface
{
    /**
     * Define how many photos are returned. Default 20, max 200.
     */
    const API_COUNT = 200;

    /**
     * VK API instance
     *
     * @var
     */
    private $api;

    /**
     * Consumer constructor.
     *
     * @param $api
     */
    public function __construct($api){

        $this->api = $api;
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

            // Make request to check how many albums user has
            $res = $this->api->call('photos.getAlbumsCount', ['user_id' => $body->id]);
            // If more than 0, then get user's photos
            if($res['response'] > 0){
                $this->_get_photos(0, $body->id);
            }
        } catch (\Exception $exception){
            var_dump($exception->getMessage());
        }

    }

    /**
     * Get photos from API, save them to DB.
     *
     * @param $receive
     * @param $id
     */
    protected function _get_photos($receive, $id){
        // Get photos from DB
        $res = $this->api->call('photos.getAll', ['owner_id' => $id, 'photo_sizes' => 1, 'offset' => $receive, 'count' => self::API_COUNT]);
        $count = $res['response']['count'];

        // Save to DB
        foreach ($res['response']['items'] as $item){
//          //TODO save to DB
        }
        // Check if user has more photos
        if($count > $receive){
            $receive += self::API_COUNT;
            $this->_get_photos($receive, $id);
        }
    }
}