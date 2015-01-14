<?php

namespace AEMR\Bundle\MarketResearchBundle\DataSource\Converter;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CsvToGeoGroupConverter {

    protected $path;
    protected $geographies;

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function getGeographies() {
        return $this->geographies;
    }

    public function setGeographies($geographies) {
        $this->geographies = $geographies;
    }

    public function convert() {
        $return = array();
        $file = new \SplFileObject($this->getPath());
        $i = 0;

        $continent = null;
        $region = null;

        $geographies = $this->getGeographies();

        while (!$file->eof()) {
            $i++;
            $data = $file->fgetcsv("\t");
            $data[0] = trim($data[0]);


            if (isset($data[0]) && ($data[0])) {
                $key = str_replace('#', '', $data[0]);
                if ($this->startsWith($data[0], '###')) {
                    $continent = $key;
                    $return[$continent] = array(
                        'name' => $data[1],
                        'type' => 'region',
                        'geos' => array()
                    );
                } else if ($this->startsWith($data[0], '##')) {
                    $region = $key;
                    $return[$region] = array(
                        'name' => $data[1],
                        'type' => 'subregion',
                        'geos' => array()
                    );
                } else {

                    $id = $this->getGeographyId($key);

                    if (null !== $id) {
                        if (null !== $continent) {
                            $return[$continent]['geos'][$key] = array(
                                'name' => $data[1],
                                'id' => $id
                            );
                        }

                        if (null !== $region) {
                            $return[$region]['geos'][$key] = array(
                                'name' => $data[1],
                                'id' => $id
                            );
                        }
                    }
                }
            }
        }
        return $return;
    }

    protected function getGeographyId($code) {
        $geographies = $this->getGeographies();
        if (isset($geographies[$code])) {
            return $geographies[$code];
        }
        return null;
    }

    function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

}

?>
