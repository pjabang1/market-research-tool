<?php

namespace AEMR\Bundle\MarketResearchBundle\DataSource\Converter;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CsvToTableConverter {

    protected $path;

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function convert($columnNames) {
        $return = array();
        $file = new \SplFileObject($this->getPath());
        $i = 0;
        while (!$file->eof()) {
            $i++;
            $data = $file->fgetcsv();
            if (1 == $i) {
                
                $header = $this->getHeader($data);
                continue;
            }
            
            
            $line = array();
            foreach($columnNames AS $columnName) {
                $col = isset($header[$columnName]) ? $header[$columnName] : null;
                if(null !== $col && isset($data[$col])) {
                    $line[$columnName] = $data[$col];
                }
            }
            if($line) {
                $return[] = $line;
            }
            
        }
        return $return;
    }

    public function getHeader($data) {
        $return = array();
        foreach($data AS $index => $columnName) {
            $return[$columnName] = $index;
        }
        return $return;
    }

}

?>
