<?php

namespace AEMR\Bundle\MarketResearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GeoModelParameterIndicator
 */
class GeoModelParameterIndicator
{
    /**
     * @var integer
     */
    private $geomodelparameter_id;

    /**
     * @var integer
     */
    private $geoindicator_id;

    /**
     * @var string
     */
    private $weight;

    /**
     * @var integer
     */
    private $aggregation_type;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set geomodelparameter_id
     *
     * @param integer $geomodelparameterId
     * @return GeoModelParameterIndicator
     */
    public function setGeomodelparameterId($geomodelparameterId)
    {
        $this->geomodelparameter_id = $geomodelparameterId;

        return $this;
    }

    /**
     * Get geomodelparameter_id
     *
     * @return integer 
     */
    public function getGeomodelparameterId()
    {
        return $this->geomodelparameter_id;
    }

    /**
     * Set geoindicator_id
     *
     * @param integer $geoindicatorId
     * @return GeoModelParameterIndicator
     */
    public function setGeoindicatorId($geoindicatorId)
    {
        $this->geoindicator_id = $geoindicatorId;

        return $this;
    }

    /**
     * Get geoindicator_id
     *
     * @return integer 
     */
    public function getGeoindicatorId()
    {
        return $this->geoindicator_id;
    }

    /**
     * Set weight
     *
     * @param string $weight
     * @return GeoModelParameterIndicator
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set aggregation_type
     *
     * @param integer $aggregationType
     * @return GeoModelParameterIndicator
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
}
