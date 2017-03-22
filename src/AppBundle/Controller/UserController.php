<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;

/**
 * Class UserController
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     * Doctrine Entity Manager
     *
     * @var EntityManager
     */
    private $em;

    /**
     * Consumer constructor.
     *
     * @param $em
     */
    public function __construct(EntityManager $em){

        $this->em = $em;
    }

    /**
     * List all users in system
     *
     * @return array
     */
    public function index(){

        return $this->em->getRepository('AppBundle:User')->findAll();
    }

}