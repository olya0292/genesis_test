<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="albums")
 */
class Album
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $title;

    /**
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $vkAlbumId;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="albums")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


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
     * Set title
     *
     * @param string $title
     *
     * @return Album
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Album
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set vkAlbumId
     *
     * @param string $vkAlbumId
     *
     * @return Album
     */
    public function setVkAlbumId($vkAlbumId)
    {
        $this->vkAlbumId = $vkAlbumId;

        return $this;
    }

    /**
     * Get vkAlbumId
     *
     * @return string
     */
    public function getVkAlbumId()
    {
        return $this->vkAlbumId;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Album
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
