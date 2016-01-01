<?php

namespace AEMR\Bundle\MarketResearchBundle\Service;

use AEMR\Bundle\MarketResearchBundle\Service\AEMRService;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class GeoIndicatorService extends AEMRService
{

    /**
     *
     * @param type $request
     * @return type
     */
    public function retrieve($request)
    {

        // $entities = $this->getEntityManager()->getRepository('AEMRMarketResearchBundle:GeoIndicator')->findAll();

        $q = $this->getEntityManager()->createQuery("SELECT i.id, i.name, i.code, i.source FROM AEMRMarketResearchBundle:GeoIndicator i");
        // $q->setParameter(':entitygroup_id', $params['id']);
        // $q->setParameter(':entity', $this->getEntity());
        return $q->getArrayResult();

        /**
         * $query_select = "SELECT i
         * FROM AEMRMarketResearchBundle:GeoIndicator i
         * "
         * ;
         *
         *
         * $query = $this->getEntityManager()
         * ->createQuery($query_select)
         * // ->setParameters($params)
         * ->setMaxResults(50);
         * ;
         *
         * $entities = $query->getResult();
         *
         * return $entities;* */
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getIndicatorsWithTotals()
    {
        $sql = "SELECT
        gi.id, gi.code, gi.name, gi.periodicity, gi.aggregation_method, gi.source, COUNT(gis.id) AS indicator_count, COUNT( DISTINCT (
            gis.geography_id
            ) ) AS geography_count, COUNT(DISTINCT(gis.date)) AS dates
FROM base_geoindicators gi
LEFT JOIN base_geoindicatorseries gis ON gi.id = gis.geoindicator_id
GROUP BY gi.id, gi.code, gi.name, gi.periodicity, gi.aggregation_method, gi.source";

$stmt = $this->getConnection()->prepare($sql);
$stmt->execute();
        //I used FETCH_COLUMN because I only needed one Column.
return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

    public function getIndicator($id) {
        return $this->getEntityManager()->getRepository('AEMRMarketResearchBundle:GeoIndicator')->find($id);
    }

    /**
     * @param $request
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getValues($request)
    {
        $return = array();
        $return['indicator'] = $this->getIndicator($request->query->get('id'));
        $return['dates'] = $this->getDates($request->query->get('id'), $request->query->get('from'), $request->query->get('to'));


        $params = array(
            'id' => $request->query->get('id'),
            // 'date' => $request->query->get('date'),
            'geogroup' => $request->query->get('geogroup'),
            'from' => $request->query->get('from'),
            'to' => $request->query->get('to'),
            'geography_ids' => $request->query->get('geography_ids'),
            );


        $last = count($return['dates'])-1;
        $params['_to'] = $return['dates'] ? $return['dates'][0]['date'] : '';
        $params['_from'] = $return['dates'] ? $return['dates'][$last]['date'] : '';

        $conditions = array();

        $conditions['id'] = $params['id'];
        $conditions['from'] = $params['from'] ? $params['from'] : $params['_from'];
        $conditions['to'] = $params['to'] ? $params['to'] : $params['_to'];

        $sql = "SELECT gis.value, gis.date, g.code
        FROM  `base_geoindicatorseries` gis
        LEFT JOIN base_geographies g ON g.id = gis.geography_id ";

        if($params['geogroup']) {
            $conditions['geogroup'] = $params['geogroup'];
            $sql = $sql . " RIGHT JOIN base_geogroupgeographies ggg ON g.id = ggg.geography_id ";
        }

        $sql = $sql . " WHERE gis.geoindicator_id = :id AND (gis.date >= :from AND gis.date <= :to)";

        if($params['geogroup']) {
            $sql = $sql . " AND ggg.geogroup_id = :geogroup";
        }

        if($params['geography_ids']) {
            $geography_ids = "(" . join(',',$params['geography_ids']) . ")";
            $sql = $sql . " AND gis.geography_id IN $geography_ids";
        }

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($conditions);
        $return["from"] = $params['_from'];
        $return["to"] = $params['_to'];
        $return['values'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $return['geographies'] = $this->getCountries($params);
        $return['total_geographies'] = count($return['geographies']);
        return $return;
    }


    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getIndicatorsWithAverages($request)
    {
        $return = array();
        $params = array(
            'id' => $request->query->get('id'),
            // 'date' => $request->query->get('date'),
            'geogroup' => $request->query->get('geogroup'),
            'from' => $request->query->get('from'),
            'to' => $request->query->get('to'),
            );

        $return['dates'] = $this->getDates($request->query->get('id'), $request->query->get('from'), $request->query->get('to'));

        $last = count($return['dates'])-1;
        $params['_to'] = $return['dates'] ? $return['dates'][0]['date'] : '';
        $params['_from'] = $return['dates'] ? $return['dates'][$last]['date'] : '';

        $conditions = array();

        $conditions['id'] = $params['id'];
        $conditions['from'] = $params['from'] ? $params['from'] : $params['_from'];
        $conditions['to'] = $params['to'] ? $params['to'] : $params['_to'];

        $sql = "SELECT
        gi.id, gi.code, gi.name, gi.periodicity, gi.aggregation_method, gis.date, COUNT(gis.id) AS indicator_count, COUNT( DISTINCT (
            gis.geography_id
            )) AS geography_count, max(gis.value) AS max, min(gis.value) AS min, IF((gis.value is NULL), 0, SUM(gis.value)) AS sum, IF((gis.value is NULL), 0, SUM(gis.value)/COUNT(gis.value)) AS  average
    FROM base_geoindicators gi
    LEFT JOIN base_geoindicatorseries gis ON gi.id = gis.geoindicator_id ";
if($params['geogroup']) {
        $conditions['geogroup'] = $params['geogroup'];
            $sql = $sql . " RIGHT JOIN base_geogroupgeographies ggg ON gis.geography_id = ggg.geography_id ";
        }

        $sql = $sql . " WHERE gis.geoindicator_id = :id AND (gis.date >= :from AND gis.date <= :to)";

        if($params['geogroup']) {
            $sql = $sql . " AND ggg.geogroup_id = :geogroup";
        }

         $sql =  $sql  . " GROUP BY gi.id, gi.code, gi.name, gi.periodicity, gi.aggregation_method, gis.date";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($conditions);
        //I used FETCH_COLUMN because I only needed one Column.
        $return['values'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $return['total_geographies'] = $this->getTotalGeographies($conditions);
        foreach($return['values'] AS $key => $value) {
            $value['completion'] = 0;
            if($value['geography_count'] && $return['total_geographies']) {
                $value['completion'] = round(($value['geography_count']/$return['total_geographies'])*100, 2);
            }
            $return['values'][$key] = $value;
        }

        return $return;
}

/**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getGeographyIndicatorsWithAverages($request)
    {
        $return = array();
        $return['indicator'] = $this->getIndicator($request->query->get('id'));
        $params = array(
            'id' => $request->query->get('id'),
            // 'date' => $request->query->get('date'),
            'geogroup' => $request->query->get('geogroup'),
            'from' => $request->query->get('from'),
            'to' => $request->query->get('to'),
            );

        $return['dates'] = $this->getDates($request->query->get('id'), $request->query->get('from'), $request->query->get('to'));

        $last = count($return['dates'])-1;
        $params['_to'] = $return['dates'] ? $return['dates'][0]['date'] : '';
        $params['_from'] = $return['dates'] ? $return['dates'][$last]['date'] : '';

        $conditions = array();

        $conditions['id'] = $params['id'];
        $conditions['from'] = $params['from'] ? $params['from'] : $params['_from'];
        $conditions['to'] = $params['to'] ? $params['to'] : $params['_to'];

        $sql = "SELECT
        gi.id, gi.code, gi.name, gi.periodicity, gi.aggregation_method, g.name, g.code, g.code_3, COUNT(gis.id) AS indicator_count, COUNT( DISTINCT (
            gis.geography_id
            )) AS geography_count, max(gis.value) AS max, min(gis.value) AS min, IF((gis.value is NULL), 0, SUM(gis.value)) AS sum, IF((gis.value is NULL), 0, SUM(gis.value)/COUNT(gis.value)) AS  average
    FROM base_geoindicators gi
    LEFT JOIN base_geoindicatorseries gis ON gi.id = gis.geoindicator_id
    LEFT JOIN base_geographies g ON g.id = gis.geography_id ";
if($params['geogroup']) {
        $conditions['geogroup'] = $params['geogroup'];
            $sql = $sql . " RIGHT JOIN base_geogroupgeographies ggg ON gis.geography_id = ggg.geography_id ";
        }

        $sql = $sql . " WHERE gis.geoindicator_id = :id AND (gis.date >= :from AND gis.date <= :to)";

        if($params['geogroup']) {
            $sql = $sql . " AND ggg.geogroup_id = :geogroup";
        }

         $sql =  $sql  . " GROUP BY gi.id, gi.code, gi.name, gi.periodicity, gi.aggregation_method, g.name, g.code, g.code_3";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($conditions);
        //I used FETCH_COLUMN because I only needed one Column.
        $return['values'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $return['total_geographies'] = $this->getTotalGeographies($conditions);
        $total = count($return['values']);
        if($total && $return['total_geographies']) {
            $return['completion'] = round(($total/$return['total_geographies'])*100, 2);
        }

        return $return;
}


    /**
    *
    *
    **/
    public function getSummarisedValues($indicator) {
        $sql = "SELECT * FROM base_geoindicatorseries gis WHERE gis.geoindicator_id = :id ORDER BY geography_id, `date` ASC";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(array('id' => $indicator));
        $values = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $prev = array();
        $return = array();
        $summaries = array();


        // $highest_rise = 0;
        // $highest_fall = 0;

        $grouped = array();
        if($values) {
            foreach($values AS $value) {
                $key = $value['geography_id'];
                if(!isset($grouped[$key])) {
                    $grouped[$key] = array();
                }
                $grouped[$key][] = $value;
            }
        }

        if($grouped ) {
            foreach($grouped AS $country) {
                $countrySummary = $this->getSummariseCountryValues($country);
                if($countrySummary) {
                    foreach($countrySummary AS $value) {
                        $summaries[] = $value;
                    }
                }
            }
        }

        return $summaries;

    }

    public function summarise($id) {
        $conn = $this->getConnection();
        $data = $this->getSummarisedValues($id);
        $params = array();
        $return = array();
        $return['summarised'] = false;
        if($data) {
            $conn->beginTransaction();
            foreach($data AS $value) {
                $params['summary'] = serialize($value);
                $params['id'] = $value['id'];
                $params['prev_id'] = $value['prev_id'];

                $sql = "UPDATE base_geoindicatorseries SET prev_id  = :id, summary = :summary WHERE id = :id";
                $q = $this->getConnection()->prepare($sql);
                $q->execute($params);

            }

            try {
                $conn->commit();
                $return['summarised'] = true;
            } catch(Exception $e) {
                $conn->rollback();

                // $return['summarised'] = true;
                throw $e;
            }
        }
        return $return;
    }

    public function getSummariseCountryValues($data) {
        $sum = 0;
        $count = 0;
        $highest = array();
        $lowest = array();
        $prev = array();
        $return = array();

        foreach($data AS $value) {
            if(!$highest) {
                $highest = $value;
            }

            if(!$lowest) {
                $lowest = $value;
            }

            $count++;
            $sum +=  $value['value'];

            $summary = array();
            $summary['id'] = $value['id'];
            $summary['change'] = '';
            $summary['prev_date'] = isset($prev['date']) ? $prev['date'] : '';
            $summary['prev_value'] = isset($prev['value']) ? $prev['value'] : '';
            $summary['prev_id'] = isset($prev['id']) ? $prev['id'] : '';
            $summary['percentage_change'] = '';

            if(isset($prev['value']) && is_numeric($prev['value']) && is_numeric($value['value'])) {
                $summary['change'] = $value['value']-$prev['value'];
                if($summary['change'] == 0 || $value['value'] == 0) {
                    $summary['percentage_change'] = 0;
                } else {
                    $summary['percentage_change'] = ($summary['change']/$value['value'])*100;
                }
            }

            if($value['value'] > $highest['value']) {
                $highest['value'] = $value['value'];
            }

            if($value['value'] < $lowest['value']) {
                $lowest['value'] = $value['value'];
            }

            $summaries[$value['id']] = $summary;
            $prev = $value;
        }

        return $summaries;
        // $return['sum'] = $sum;
        // $return['count'] = $count;


    }

    public function getContentKeys($content) {

        $header = $content[0];
        $keys = array();
        $dates = array();
        foreach($header AS $key => $value) {
            $value = trim($value);
            $lower = strtolower($value);
            if($lower == 'country' || $lower == 'country_code') {
                $keys['country'] = $key;
            }  else if (\DateTime::createFromFormat('Y', $value) !== FALSE) {
                $dates[$value] = $key;
            // it's a date
            }
        }

        $keys['dates'] = $dates;

        return $keys;

    }


    function getCountryId($string, $countries) {
        foreach($countries AS $value) {
            if($value['code'] == $string || $value['numerical_code'] == $string || $value['code_3'] == $string || $value['name'] == $string) {
                return $value['id'];
            }
        }
        return 0;
    }

    function hydrateContent($content, $keys, $countries, $id) {
        $i = 0;
        $return = array();
        foreach($content AS $key => $value) {
            $i++;
            if($i == 1) {
                continue;
            }
                $country = isset($value[$keys['country']]) ? $value[$keys['country']] : null;

                if($country) {
                    $geography_id = $this->getCountryId($country, $countries);
            foreach($keys['dates'] AS $date => $dateKey) {
                if(isset($value[$dateKey])) {
                $line = array();
                $line['geography_id'] = $geography_id;
                $line['date'] = $date;
                $line['value'] = $value[$dateKey];
                $key = $line['geography_id'] . '#' . $id . '#' . $line['date'];
                $return[$key] = $line;
            }

            }
        }

        }
        return $return;
    }

    public function replaceIndicatorSeries($id, $series) {
        $conn = $this->getConnection();
        $return = array();
        $return['replaced'] = false;
         if($series) {
            $conn->beginTransaction();
                $deleteSql = "DELETE FROM base_geoindicatorseries WHERE geoindicator_id = :id";
                $dq = $this->getConnection()->prepare($deleteSql);
                $dq->execute(array('id' => $id));

            foreach($series AS $value) {


                $value['geoindicator_id'] = $id;
                $params = array();
                $params['geoindicator_id'] = $value['geoindicator_id'];
                $params['geography_id'] = $value['geography_id'];
                $params['date'] = $value['date'];
                $params['value'] = $value['value'];
                if($params['geography_id']) {
                    $sql = "INSERT INTO base_geoindicatorseries (geoindicator_id, geography_id, `date`, `value`) VALUES (:geoindicator_id, :geography_id, :date, :value)";
                                $q = $this->getConnection()->prepare($sql);
                $q->execute($params);
                }


            }

            try {
                $conn->commit();
                $return['replaced'] = true;
            } catch(Exception $e) {
                $conn->rollback();

                // $return['summarised'] = true;
                throw $e;
            }
        }

        return $return;
    }

    public function unserializeContent($id) {

        $return  = array();

        $sql = "SELECT content FROM base_geoindicators gi WHERE gi.id = :id AND gi.source = 'local'";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(array('id' => $id));
        //I used FETCH_COLUMN because I only needed one Column.
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        $sql = "SELECT g.* FROM base_geographies g";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        $countries = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if($data && $data['content']) {
            $content = unserialize($data['content']);
            $keys = $this->getContentKeys($content);

            $series = $this->hydrateContent($content, $keys, $countries, $id);
            $return = $this->replaceIndicatorSeries($id, $series);


        }


        return $return;


    }


    public function getAggregatedValues($values) {
        $return = array();

        if($values) {
            foreach($values AS $value) {
                $key = $value['geoindicator_id'] . '#' . $value['geography_id'];
                if(!isset($return[$key])) {
                    $value['max_value'] = $value['value'];
                    $value['min_value'] = $value['value'];
                    $value['max_date'] = $value['date'];
                    $value['min_date'] = $value['date'];
                    $value['count'] = 1;
                    $value['sum'] = $value['value'];
                    $return[$key] = $value;
                } else {


                }
            }
        }
    }

    public function getCountries($params) {
        $sql = "SELECT * FROM base_geographies";
        if($params['geography_ids']) {
            $geography_ids = "(" . join(',',$params['geography_ids']) . ")";
            $sql = $sql . " WHERE id IN $geography_ids";
        }
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        $return = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $return;

    }


    public function getTotalGeographies($params) {
        $conditions = array();
        $sql = "SELECT count(*) AS counter FROM base_geographies";
        if(isset($params['geogroup'])) {
            $sql = "SELECT count(*) AS counter FROM base_geogroupgeographies ggg WHERE ggg.geogroup_id = :geogroup_id";
            $conditions = array('geogroup_id' => $params['geogroup']);
        }

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($conditions);
        $return = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $return['counter'];

    }

    /**
     * @param $id
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */


    public function getDates($id, $from, $to) {
      $fromToDates = $this->getFromToDates($id);
      $fromToDates["from"] = $fromToDates["to"]-5;
      $from = !$from ? $fromToDates["from"] : $from;
      $to = !$to ? $fromToDates["to"] : $to;
      return $this->createDateSeries($from, $to);
    }

    public function getFromToDates($id)
    {
        $sql = "SELECT max(date) AS `to`, min(date) AS `from`
        FROM `base_geoindicatorseries`
        WHERE `geoindicator_id` = :id AND `value` != 0
        ORDER BY date DESC";
        return $this->getConnection()->fetchAssoc($sql, array('id' => $id));
    }


    public function createDateSeries($from, $to) {
      $dates = array();
      for($i = $to; $i >= $from; $i--) {
        $date = (string) $i;
        $dates[] = array("date" => $date);
      }
      return $dates;
    }


    public function insert($data) {
        $d = array();
        $d['name'] = $data['name'] ? $data['name'] : '';
        $d['source'] = 'local';
        $d['code'] = $data['code'] ? $data['code'] : '';
        $d['description'] = $data['description'] ? $data['description'] : '';
        $d['content'] = $data['series'] ? $data['series'] : array();
        $d['content'] = $this->serialize($d['content']);

        $sql = "INSERT INTO base_geoindicators (name,source,code,description,content) VALUES (:name,:source,:code,:description,:content)";
        $q = $this->getConnection()->prepare($sql);
        $q->execute($d);
        $lastId = $this->getConnection()->lastInsertId();
        $this->updateSeries($lastId);
        return $this->get($lastId);

    }

    public function get($id) {
        $encoder = new JsonEncoder();
        $q = $this->getEntityManager()->createQuery("SELECT gi FROM AEMRMarketResearchBundle:GeoIndicator gi WHERE gi.id = :id");
        $q->setParameter(':id', $id);
        $result = $q->getArrayResult();
        if($result) {
            $result = $result[0];
            $result['series'] = $result['content'] ? unserialize($result['content']) : array();
            unset($result['content']);
        }
        return $result;
    }

    public function serialize($content) {
        $return = array();
        foreach($content AS $value) {
            $return[] = $this->cleanLine($value);
        }
        return serialize($return);
    }

    public function cleanLine($line) {
        $return = array();
        foreach($line AS $value) {
            if($value == null) {
                $value = '';
            }
            $return[] = $value;
        }
        return $return;
    }

    public function update($data) {
        $d = array();
        $d['id'] = $data['id'] ? $data['id'] : '';
        if(!$d['id']) {
            throw new \Exception('No id submitted');
        }
        $d['name'] = $data['name'] ? $data['name'] : '';
        $d['code'] = $data['code'] ? $data['code'] : '';
        $d['description'] = $data['description'] ? $data['description'] : '';
        $d['content'] = $data['series'] ? $data['series'] : array();
        $d['content'] = $this->serialize($d['content']);

        $sql = "UPDATE base_geoindicators SET name = :name, code = :code, description = :description, content = :content WHERE id = :id";
        $q = $this->getConnection()->prepare($sql);
        $q->execute($d);
        $this->updateSeries($d['id']);

        return $this->get($d['id']);
    }

    public function updateSeries($id) {
         $this->unserializeContent($id);
         $this->summarise($id);
    }
}
