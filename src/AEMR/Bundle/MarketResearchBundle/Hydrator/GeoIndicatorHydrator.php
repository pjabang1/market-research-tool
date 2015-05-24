<?php

namespace AEMR\Bundle\MarketResearchBundle\Hydrator;

class GeoIndicatorHydrator {
    protected $list = array();

    public function hydrate($data) {
        $return = array();

    }

    public function deHydrate($data) {
        $result = $data;
        $result['series'] = array();
        if($data['series']) {
            foreach($data['series'] AS $key => $line) {
                
            }
        }
    }

    public function setList($list) {
        $this->list = $list;
        return $this;
    }

    public function getList() {
        return $this->list;
    }


}
