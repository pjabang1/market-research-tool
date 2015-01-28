<?php

namespace AEMR\Bundle\MarketResearchBundle\Service;

use AEMR\Bundle\MarketResearchBundle\Service\AEMRService;

class GeoModelService extends AEMRService {

    /**
     * 
     * @param type $request
     * @return type
     */
    public function retrieve($request) {
        $em = $this->getEntityManager();

        $entities = $em->getRepository('AEMRMarketResearchBundle:GeoModel')->findAll();

        return $entities;
    }

    /**
     * 
     * @param type $request
     * @return type
     */
    public function getValues($request) {
        $params = array(
            'id' => $request->query->get('id'),
            'geogroup_id' => $request->query->get('geogroup_id'),
            'date' => $request->query->get('date'),
        );

        // return $request->request->all();
        $sql = "SELECT gm.id AS geomodel_id, g.id AS geography_id, gi.id AS geoindicator_id, gm.`algorithm_code`, gmpi.weight,gmp.id AS parameter_id, gmp.name AS parameter, gis.value AS value, gis.date
                FROM  `base_geomodels` gm CROSS JOIN base_geogroups gg 
                LEFT JOIN base_geogroupgeographies ggg ON ggg.geogroup_id = gg.`id` 
                LEFT JOIN base_geographies g ON g.id = ggg.geography_id
                LEFT JOIN base_geomodelparameters gmp ON gmp.geomodel_id = gm.id
                LEFT JOIN base_geomodelparameterindicators gmpi ON gmpi.geomodelparameter_id = gmp.id
                LEFT JOIN base_geoindicators gi ON gi.id = gmpi.geoindicator_id
                LEFT JOIN base_geoindicatorseries gis ON gis.geoindicator_id = gi.id
                AND gis.geography_id = g.id
                WHERE gg.id = :geogroup_id AND gm.id = :id AND gis.date = :date 
                ORDER BY  `g`.`name` ASC";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        //I used FETCH_COLUMN because I only needed one Column.
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 
     * @param type $request
     * @return type
     */
    public function getGeographies($request) {
        $params = array(
            'id' => $request->query->get('id'),
            'geogroup_id' => $request->query->get('geogroup_id'),
        );
        $sql = "SELECT g.*
                FROM  `base_geomodels` gm CROSS JOIN base_geogroups gg 
                LEFT JOIN base_geogroupgeographies ggg ON ggg.geogroup_id = gg.`id` 
                LEFT JOIN base_geographies g ON g.id = ggg.geography_id 
                WHERE gg.id = :geogroup_id AND gm.id = :id 
                ORDER BY  `g`.`name` ASC";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        //I used FETCH_COLUMN because I only needed one Column.
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 
     * @param type $request
     * @return type
     */
    public function getIndicators($request) {
        $params = array(
            'id' => $request->query->get('id')
        );
        $sql = "SELECT gmp.id AS parameter_id, gmp.name AS parameter_name, gmpi.geoindicator_id, gmpi.weight, gi.* 
                FROM  `base_geomodels` gm
                LEFT JOIN base_geomodelparameters gmp ON gmp.geomodel_id = gm.id
                LEFT JOIN base_geomodelparameterindicators gmpi ON gmpi.geomodelparameter_id = gmp.id
                LEFT JOIN base_geoindicators gi ON gi.id = gmpi.geoindicator_id 
                WHERE gm.id = :id 
                ORDER BY  `gi`.`name` ASC";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        //I used FETCH_COLUMN because I only needed one Column.
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
