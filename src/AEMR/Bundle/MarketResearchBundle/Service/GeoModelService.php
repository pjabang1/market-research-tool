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
      //  $em = $this->getEntityManager();
        // $entities = $em->getRepository('AEMRMarketResearchBundle:GeoModel')->findAll();
        // return $entities;
        $sql = "SELECT id, name, algorithm_code, geogroup_id, description FROM `base_geomodels`";
        $stmt = $this->getConnection()->prepare($sql);
        // $params
        $stmt->execute();
        //I used FETCH_COLUMN because I only needed one Column.
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
        $sql = "SELECT g.id AS geography_id, gi.id AS geoindicator_id, gmpi.weight,gmp.id AS parameter_id,  gis.value AS value
                FROM  `base_geomodels` gm CROSS JOIN base_entitygroups gg
                LEFT JOIN base_entitygroupentities ggg ON ggg.entitygroup_id = gg.`id`
                LEFT JOIN base_geographies g ON g.id = ggg.entity_id
                LEFT JOIN base_geomodelparameters gmp ON gmp.geomodel_id = gm.id
                LEFT JOIN base_geomodelparameterindicators gmpi ON gmpi.geomodelparameter_id = gmp.id
                LEFT JOIN base_geoindicators gi ON gi.id = gmpi.geoindicator_id
                LEFT JOIN base_geoindicatorseries gis ON gis.geoindicator_id = gi.id
                AND gis.geography_id = g.id
                WHERE gg.id = :geogroup_id AND gm.id = :id AND gis.date = :date AND gg.entity = 'geography'
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
                FROM  `base_geomodels` gm CROSS JOIN base_entitygroups gg
                LEFT JOIN base_entitygroupentities ggg ON ggg.entitygroup_id = gg.`id`
                LEFT JOIN base_geographies g ON g.id = ggg.entity_id
                WHERE gg.id = :geogroup_id AND gm.id = :id AND gg.entity = 'geography'
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
    public function getParameters($request) {
        return $this->_getParameters($request->query->get('id'));
    }

    /**
     *
     * @param type $request
     * @return type
     */
    protected function _getParameters($id) {
        $q = $this->getEntityManager()->createQuery("SELECT gmp FROM AEMRMarketResearchBundle:GeoModelParameter gmp WHERE gmp.geomodel_id = :geomodel_id");
        $q->setParameter(':geomodel_id', $id);
        return $q->getArrayResult();
    }

    /**
     *
     * @param type $request
     * @return type
     */
    public function getIndicators($request) {
        return $this->_getIndicators($request->query->get('id'));
    }

    /**
     *
     * @param type $request
     * @return type
     */
    protected function _getIndicators($id) {
        $params = array(
            'id' => $id
        );
        $sql = "SELECT gmp.id AS parameter_id, gmp.name AS parameter_name, gmpi.geoindicator_id, gmpi.weight, gi.*, gmpi.relevance_sort
                FROM  `base_geomodels` gm
                LEFT JOIN base_geomodelparameters gmp ON gmp.geomodel_id = gm.id
                LEFT JOIN base_geomodelparameterindicators gmpi ON gmpi.geomodelparameter_id = gmp.id
                LEFT JOIN base_geoindicators gi ON gi.id = gmpi.geoindicator_id
                WHERE gm.id = :id
                ORDER BY  `gi`.`name` ASC";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getModel($id) {
        return $this->_get($id);
    }

    /**
     *
     * @param type $id
     * @return type
     */
    public function newModel($id) {
        $return = $this->_getEmptyModel('ge_matrix');
        $model = $this->_get($id);
        if ($model) {

            // print_r($model);
            $parameters = $this->_getParametersWithIndicators($model["id"]);
            if ($parameters) {
                $model['parameters'] = $parameters;
            } else {
                $model['parameters'] = $return['parameters'];
            }
            return $model;
        }
        return $return;
    }

    /**
     *
     * @param int $id
     * @return array
     */
    protected function _getParametersWithIndicators($id) {
        $parameters = $this->_getParameters($id);
        $indicators = $this->_getIndicators($id);

        $return = array();
        foreach ($parameters AS $parameter) {
            $return[$parameter['id']] = $parameter;
            $return[$parameter['id']]['indicators'] = array();
        }

        foreach ($indicators AS $indicator) {
            if (isset($return[$indicator['parameter_id']])) {
                $return[$indicator['parameter_id']]['indicators'][] = $indicator;
            }
        }
        return $return;
    }

    /**
     *
     * @param string $type
     * @return array
     */
    protected function _getEmptyModel($type) {
        $return = array('algorithm_code' => $type, 'name' => '', 'description' => '');
        $return['parameters'] = array();
        $return['parameters'][] = array(
            'id' => 1,
            'axis' => 'x',
            'code' => 'BUS',
            'name' => 'Business Unit Strength',
            'indicators' => array()
        );
        $return['parameters'][] = array(
            'id' => 2,
            'axis' => 'y',
            'code' => 'IA',
            'name' => 'Industry Attractiveness',
            'indicators' => array()
        );

        return $return;
    }

    /**
     *
     * @param int $id
     * @return array
     */
    protected function _get($id) {

        $q = $this->getEntityManager()->createQuery("SELECT gm FROM AEMRMarketResearchBundle:GeoModel gm WHERE gm.id = :id");
        $q->setParameter(':id', $id);
        $result = $q->getArrayResult();
        if ($result) {
            return $result[0];
        }
        return array();
    }

    public function replace($data) {

        if (isset($data['id']) && $data['id']) {
            return $this->update($data);
        } else {
            return $this->insert($data);
        }

    }

    public function update($data) {
      $this->getConnection()->update('base_geomodels', $data, array('id' => $data['id']));
      return $data['id'];
    }

    public function insert($data) {
      $this->getConnection()->insert('base_geomodels', $data);
      return $this->getConnection()->lastInsertId();
    }

    public function __insert($data) {
        $this->getConnection()->beginTransaction();
        try {
            $this->getConnection()->insert('base_geomodels', $data['model']);
            $model_id = $this->getConnection()->lastInsertId();
            if (isset($data['parameters']) && $data['parameters']) {
                foreach ($data['parameters'] AS $value) {
                    $parameter = $value['parameter'];
                    $parameter['geomodel_id'] = $model_id;

                    $indicators = isset($value['indicators']) ? $value['indicators'] : array();


                    if(isset($parameter['id'])) {
                        unset($parameter['id']);
                    }


                    $this->getConnection()->insert('base_geomodelparameters', $parameter);
                    $parameter_id = $this->getConnection()->lastInsertId();
                    if($indicators) {
                        foreach($indicators AS $indicator) {
                            $indicator['geomodelparameter_id'] = $parameter_id;
                             $this->getConnection()->insert('base_geomodelparameterindicators', $indicator);
                        }
                    }

                }
            }
            $try = $this->getConnection()->commit();
            return array('message' => 'insert');
        } catch (Exception $e) {
            $try = $this->getConnection()->rollback();
            throw $e;
        }

    }

}
