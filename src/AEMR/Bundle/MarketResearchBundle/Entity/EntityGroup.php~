<?php

namespace AEMR\Bundle\MarketResearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntityGroup
 */
class EntityGroup {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $user_id;

    /**
     * @var integer
     */
    private $client_id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * @var integer
     */
    private $id;

    public function __construct() {
        $this->setModified(new \DateTime());
        $this->setCreated(new \DateTime());
    }

    /**
     * Set name
     *
     * @param string $name
     * @return EntityGroup
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set entity
     *
     * @param string $entity
     * @return EntityGroup
     */
    public function setEntity($entity) {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string 
     */
    public function getEntity() {
        return $this->entity;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return EntityGroup
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return EntityGroup
     */
    public function setUserId($userId) {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * Set client_id
     *
     * @param integer $clientId
     * @return EntityGroup
     */
    public function setClientId($clientId) {
        $this->client_id = $clientId;

        return $this;
    }

    /**
     * Get client_id
     *
     * @return integer 
     */
    public function getClientId() {
        return $this->client_id;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return EntityGroup
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return EntityGroup
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return EntityGroup
     */
    public function setModified($modified) {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime 
     */
    public function getModified() {
        return $this->modified;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

}
