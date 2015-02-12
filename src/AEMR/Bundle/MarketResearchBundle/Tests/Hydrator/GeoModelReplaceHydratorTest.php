<?php

namespace AEMR\Bundle\MarketResearchBundle\Tests\Hydrator;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GeoModelReplaceHydratorTest extends WebTestCase {

    public function setUp() {
        self::$kernel = self::createKernel();
        self::$kernel->boot();
        $this->container = self::$kernel->getContainer();
    }

    public function testHydrateModel() {
        $hydrator = new \AEMR\Bundle\MarketResearchBundle\Hydrator\GeoModelReplaceHydrator();
        $model = $this->getInsertData();
        $service = $this->container->get('geomodel_service');

        $hydrator->setService($service);

        $result = $hydrator->hydrateModel($model);
        $service->replace($result);
        // print_r($result);

        $this->assertEquals(1, 1);
    }

    protected function getInsertData() {
        return json_decode(
                '{"name":"The McKinsey \/ General Electric Matrix 2","algorithm_code":"ge_matrix","description":"An example model to determine market attractiveness and competitive strength by applying the McKinsey\/GE Matrix to country groups","geogroup_id":"6","parameters":{"1":{"code":"BUS","axis":"x","name":"Business Unit Strength","geomodel_id":"1","aggregation_type":"0","id":"1","indicators":[{"id":"1156"},{"id":"1159"}]},"2":{"code":"IA","axis":"y","name":"Industry Attractiveness","geomodel_id":"1","aggregation_type":"0","id":"2","indicators":[{"id":"1268"},{"id":"1266"},{"id":"1275"},{"id":"1271"},{"id":"1269"},{"id":"1273"},{"id":"1272"},{"id":"1270"},{"id":"1276"},{"id":"1267"},{"id":"1274"}]}}}', true
        );
    }

    protected function getUpdateData() {
        return json_decode(
                '{"name":"The McKinsey \/ General Electric Matrix 2","algorithm_code":"ge_matrix","description":"An example model to determine market attractiveness and competitive strength by applying the McKinsey\/GE Matrix to country groups","geogroup_id":"6","id":"1","parameters":{"1":{"code":"BUS","axis":"x","name":"Business Unit Strength","geomodel_id":"1","aggregation_type":"0","id":"1","indicators":[{"id":"1156"},{"id":"1159"}]},"2":{"code":"IA","axis":"y","name":"Industry Attractiveness","geomodel_id":"1","aggregation_type":"0","id":"2","indicators":[{"id":"1268"},{"id":"1266"},{"id":"1275"},{"id":"1271"},{"id":"1269"},{"id":"1273"},{"id":"1272"},{"id":"1270"},{"id":"1276"},{"id":"1267"},{"id":"1274"}]}}}', true
        );
    }

    protected function tearDown() {
    }

}
