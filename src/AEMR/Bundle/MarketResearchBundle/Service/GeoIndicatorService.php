<?php

namespace AEMR\Bundle\MarketResearchBundle\Service;

use AEMR\Bundle\MarketResearchBundle\Service\AEMRService;

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

        $q = $this->getEntityManager()->createQuery("SELECT i.id, i.name, i.code FROM AEMRMarketResearchBundle:GeoIndicator i");
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
        gi.id, gi.code, gi.name, gi.periodicity, gi.aggregation_method, COUNT(gis.id) AS indicator_count, COUNT( DISTINCT (
        gis.geography_id
        ) ) AS geography_count
        FROM base_geoindicators gi
        LEFT JOIN base_geoindicatorseries gis ON gi.id = gis.geoindicator_id
        GROUP BY gi.id, gi.code, gi.name, gi.periodicity, gi.aggregation_method";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        //I used FETCH_COLUMN because I only needed one Column.
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $request
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getValues($request)
    {
        $return = array();
        $return['indicator'] = $this->getEntityManager()->getRepository('AEMRMarketResearchBundle:GeoIndicator')->find($request->query->get('id'));
        $return['dates'] = $this->getDates($request->query->get('id'));
        $params = array(
            'id' => $request->query->get('id'),
            'date' => $request->query->get('date'),
        );

        if (!$params['date'] && $return['dates']) {
            $params['date'] = $return['dates'][0]['date'];
        }

        $sql = "SELECT gis.id, gis.geoindicator_id, gis.geography_id, gis.value, gis.date, g.name, g.code, g.code_3
                FROM  `base_geoindicatorseries` gis
                LEFT JOIN base_geographies g ON g.id = gis.geography_id
                WHERE gis.geoindicator_id = :id AND gis.date = :date";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        $return['values'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $return;
    }

    /**
     * @param $id
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getDates($id)
    {
        $sql = "SELECT distinct(date)  AS date
                FROM `base_geoindicatorseries`
                WHERE `geoindicator_id` = :id
                ORDER BY date DESC";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(array('id' => $id));
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
