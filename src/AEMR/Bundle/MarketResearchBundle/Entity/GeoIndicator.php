<?php

namespace AEMR\Bundle\MarketResearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GeoIndicator
 */
class GeoIndicator
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $geo_type = '';

    /**
     * @var string
     */
    private $value_type;

    /**
     * @var string
     */
    private $date_type = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var integer
     */
    private $id;
    



    /**
     * Set code
     *
     * @param string $code
     * @return GeoIndicator
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

    /**
     * Set name
     *
     * @param string $name
     * @return GeoIndicator
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
     * Set geo_type
     *
     * @param string $geoType
     * @return GeoIndicator
     */
    public function setGeoType($geoType)
    {
        $this->geo_type = $geoType;

        return $this;
    }

    /**
     * Get geo_type
     *
     * @return string 
     */
    public function getGeoType()
    {
        return $this->geo_type;
    }

    /**
     * Set value_type
     *
     * @param string $valueType
     * @return GeoIndicator
     */
    public function setValueType($valueType)
    {
        $this->value_type = $valueType;

        return $this;
    }

    /**
     * Get value_type
     *
     * @return string 
     */
    public function getValueType()
    {
        return $this->value_type;
    }

    /**
     * Set date_type
     *
     * @param string $dateType
     * @return GeoIndicator
     */
    public function setDateType($dateType)
    {
        $this->date_type = $dateType;

        return $this;
    }

    /**
     * Get date_type
     *
     * @return string 
     */
    public function getDateType()
    {
        return $this->date_type;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return GeoIndicator
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
    private $periodicity = '';

    /**
     * @var string
     */
    private $base_period = '';

    /**
     * @var string
     */
    private $status = '';

    /**
     * @var string
     */
    private $aggregation_method = '';


    /**
     * Set periodicity
     *
     * @param string $periodicity
     * @return GeoIndicator
     */
    public function setPeriodicity($periodicity)
    {
        $this->periodicity = $periodicity;

        return $this;
    }

    /**
     * Get periodicity
     *
     * @return string 
     */
    public function getPeriodicity()
    {
        return $this->periodicity;
    }

    /**
     * Set base_period
     *
     * @param string $basePeriod
     * @return GeoIndicator
     */
    public function setBasePeriod($basePeriod)
    {
        if(null === $basePeriod) {
            $basePeriod = '';
        }
        $this->base_period = $basePeriod;

        return $this;
    }

    /**
     * Get base_period
     *
     * @return string 
     */
    public function getBasePeriod()
    {
        return $this->base_period;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return GeoIndicator
     */
    public function setStatus($status)
    {
         if(null === $status) {
            $status = '';
        }
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set aggregation_method
     *
     * @param string $aggregationMethod
     * @return GeoIndicator
     */
    public function setAggregationMethod($aggregationMethod)
    {
        if(null === $aggregationMethod) {
            $aggregationMethod = '';
        }
        $this->aggregation_method = $aggregationMethod;

        return $this;
    }

    /**
     * Get aggregation_method
     *
     * @return string 
     */
    public function getAggregationMethod()
    {
        return $this->aggregation_method;
    }
    /**
     * @var string
     */
    private $source;


    /**
     * Set source
     *
     * @param string $source
     * @return GeoIndicator
     */
    public function setSource($source)
    {
        
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }
}
