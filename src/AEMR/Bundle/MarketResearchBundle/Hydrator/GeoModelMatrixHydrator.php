<?php

namespace AEMR\Bundle\MarketResearchBundle\Hydrator;

class GeoModelMatrixHydrator {

    protected $data;

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function hydrator() {
        $data = $this->getData();
    }

    public function getHeader($data, $parameterId) {
        $return = array();
        foreach ($data['indicators'] AS $value) {
            if ($value['parameter_id'] == $parameterId) {
                $value['label'] = $value['name'];
                $return[] = $value;
            }
        }
        return $return;
    }

    protected function getValues($data) {
        $return = array();
        foreach ($data['values'] AS $value) {
            $key = $value['parameter_id'] . '#' . $value['geography_id'] . '#' . $value['geoindicator_id'];
            $value['key'] = $key;
            if (!isset($return[$value['parameter_id']])) {
                $return[$value['parameter_id']] = array();
            }
            $return[$value['parameter_id']][$key] = $value;
        }
        return $return;
    }

}
