<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $vkId;

    /**
     * @ORM\OneToMany(targetEntity="Album", mappedBy="user")
     */
    private $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set vkId
     *
     * @param string $vkId
     *
     * @return User
     */
    public function setVkId($vkId)
    {
        $this->vkId = $vkId;

        return $this;
    }

    /**
     * Get vkId
     *
     * @return string
     */
    public function getVkId()
    {
        return $this->vkId;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Add album
     *
     * @param \AppBundle\Entity\Album $album
     *
     * @return User
     */
    public function addAlbum(\AppBundle\Entity\Album $album)
    {
        $this->albums[] = $album;

        return $this;
    }

    /**
     * Remove album
     *
     * @param \AppBundle\Entity\Album $album
     */
    public function removeAlbum(\AppBundle\Entity\Album $album)
    {
        $this->albums->removeElement($album);
    }

    /**
     * Get albums
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbums()
    {
        return $this->albums;
    }
}
