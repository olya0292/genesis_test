<?php
namespace AppBundle\Services;

/**
 * Class Producer
 * @package AppBundle\Services
 */
class Producer
{
    /**
     * Producer instance
     * @var
     */
    private $producer;

    /**
     * Producer constructor.
     *
     * @param $producer
     */
    public function __construct($producer){

        $this->producer = $producer;
    }

    /**
     * Function process arguments from command and publish message.
     *
     * @param $message
     */
    public function process($message){

        if($message['src_type'] === 'file'){
            //TODO parse CSV file
        }

        if($message['src_type'] === 'id'){
            //Rabbit MQ want the message to be serialized
            $this->producer->publish(serialize(json_encode(array('id' => $message['id']))));
        }

    }
}