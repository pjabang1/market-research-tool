<?php
namespace AEMR\Bundle\MarketResearchBundle\Algorithm\Matrix\GeMatrix;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class GeMatrix {
    
    protected $description;
    
    protected $code = 'geMatrix';


    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;
        return $this;
    }
    
     

    

    
}

