<?php

namespace AEMR\Bundle\MarketResearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GeoModelParameter
 */
class GeoModelParameter
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $geomodel_id;

    /**
     * @var integer
     */
    private $aggregation_type;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     * @return GeoModelParameter
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
     * Set geomodel_id
     *
     * @param integer $geomodelId
     * @return GeoModelParameter
     */
    public function setGeomodelId($geomodelId)
    {
        $this->geomodel_id = $geomodelId;

        return $this;
    }

    /**
     * Get geomodel_id
     *
     * @return integer 
     */
    public function getGeomodelId()
    {
        return $this->geomodel_id;
    }

    /**
     * Set aggregation_type
     *
     * @param integer $aggregationType
     * @return GeoModelParameter
     */
    public function setAggregationType($aggregationType)
    {
        $this->aggregation_type = $aggregationType;

        return $this;
    }

    /**
     * Get aggregation_type
     *
     * @return integer 
     */
    public function getAggregationType()
    {
        return $this->aggregation_type;
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
     * @var string
     */
    private $code;


    /**
     * Set code
     *
     * @param string $code
     * @return GeoModelParameter
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
}
