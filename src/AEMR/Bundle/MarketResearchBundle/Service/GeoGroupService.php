<?php

namespace AEMR\Bundle\MarketResearchBundle\Service;

use AEMR\Bundle\MarketResearchBundle\Service\AEMRService;

class GeoGroupService extends AEMRService {

	/**
	 * 
	 * @param type $request
	 * @return type
	 */
	public function retrieve($request) {
		$em = $this->getEntityManager();

		$entities = $em->getRepository('AEMRMarketResearchBundle:GeoGroup')->findAll();

		return $entities;
	}

	/**
	 * 
	 * @param type $request
	 * @return type
	 */
	public function getGeographies($request) {
		$params = array(
			'id' => $request->query->get('id')
		);
		$sql = "SELECT ggg.geography_id 
				FROM base_geogroupgeographies ggg 
				WHERE ggg.geogroup_id = :id";

		$stmt = $this->getConnection()->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * 
	 * @param type $request
	 * @return type
	 */
	public function get($request) {
		$em = $this->getEntityManager();
		return $em->getRepository('AEMRMarketResearchBundle:GeoGroup')->find($request->query->get('id'));
	}

}
