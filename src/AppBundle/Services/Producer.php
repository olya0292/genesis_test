<?php
namespace AppBundle\Services;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
     * Logger instance
     * @var
     */
    private $logger;
    /**
     * Producer constructor.
     *
     * @param $producer
     * @param $logger
     */
    public function __construct($producer, $logger){

        $this->producer = $producer;
        $this->logger = $logger;
    }

    /**
     * Function process arguments from command and publish message.
     *
     * @param $message
     */
    public function process($message){
        try{
            // Parse csv file
            if($message['src_type'] === 'file'){
                $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
                $data = $serializer->decode(file_get_contents($message['id']), 'csv');
                foreach ($data as $item){
                    $this->producer->publish(serialize(json_encode(array('id' => $item['id']))));
                }
            }

            if($message['src_type'] === 'id'){
                //Rabbit MQ want the message to be serialized
                $this->producer->publish(serialize(json_encode(array('id' => $message['id']))));
            }
        } catch (\Exception $exception){
            $this->logger->error(sprintf('Error: "%s"', $exception->getMessage()));
        }
    }
}