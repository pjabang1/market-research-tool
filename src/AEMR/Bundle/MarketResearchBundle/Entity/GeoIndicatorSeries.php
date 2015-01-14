<?php

namespace AEMR\Bundle\MarketResearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GeoIndicatorSeries
 */
class GeoIndicatorSeries
{
    /**
     * @var integer
     */
    private $geoindicator_id;

    /**
     * @var integer
     */
    private $geography_id;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $date;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set geoindicator_id
     *
     * @param integer $geoindicatorId
     * @return GeoIndicatorSeries
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
     * Set geography_id
     *
     * @param integer $geographyId
     * @return GeoIndicatorSeries
     */
    public function setGeographyId($geographyId)
    {
        $this->geography_id = $geographyId;

        return $this;
    }

    /**
     * Get geography_id
     *
     * @return integer 
     */
    public function getGeographyId()
    {
        return $this->geography_id;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return GeoIndicatorSeries
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return GeoIndicatorSeries
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
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
