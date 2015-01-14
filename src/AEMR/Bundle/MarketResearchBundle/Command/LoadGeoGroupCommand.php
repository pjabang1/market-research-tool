<?php

namespace AEMR\Bundle\MarketResearchBundle\Command;

ini_set('memory_limit', '200M');

use AEMR\Bundle\MarketResearchBundle\Command\ConnectionAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Hibu\OM5Bundle\Entity\TermTree;
use AEMR\Bundle\MarketResearchBundle\DataSource\Converter\CsvToGeoGroupConverter;
use AEMR\Bundle\MarketResearchBundle\Entity\GeoGroup;
use AEMR\Bundle\MarketResearchBundle\Entity\GeoGroupGeography;

class LoadGeoGroupCommand extends ConnectionAwareCommand {

    protected function configure() {
        $this
                ->setName('load:geogroup')
                ->addArgument(
                        'file', InputArgument::REQUIRED, 'File'
                )
                ->setDescription('Load Geo Groups')

        ;
    }

    /**
     * /var/www/aitools/web/uploads/term_properties/
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        $file = $input->getArgument('file');

        $em = $this->getEntityManager();

        $geographies = array();
        $entities = $em->getRepository('AEMRMarketResearchBundle:Geography')->findAll();

        if ($entities) {
            foreach ($entities AS $entity) {
                $geographies[$entity->getNumericalCode()] = $entity->getId();
            }
        }

        $geoGroupEntity = 'AEMRMarketResearchBundle:GeoGroup';
        $geoGroupGeographyEntity = 'AEMRMarketResearchBundle:GeoGroupGeography';
        // print_r($geographies);

        $csvToTableConverter = new CsvToGeoGroupConverter();
        $csvToTableConverter->setPath($file);
        $csvToTableConverter->setGeographies($geographies);

        $data = $csvToTableConverter->convert();


        foreach ($data AS $region) {
            $geoGroup = $em->getRepository($geoGroupEntity)->findOneBy(array('type' => $region['type'], 'name' => $region['name']));
            if (!$geoGroup) {
                $geoGroup = new GeoGroup();
                $geoGroup->setName($region['name'])
                        ->setType($region['type'])
                        ->setDescription('');

                $em->persist($geoGroup);
                $em->flush();
            }
            
            if($region['geos'] && $geoGroup->getId()) {
                foreach($region['geos'] AS $geo) {
                    $geoGroupGeography = $em->getRepository($geoGroupGeographyEntity)->findOneBy(array('geogroup_id' => $geoGroup->getId(), 'geography_id' => $geo['id']));
                    if(!$geoGroupGeography) {
                        $geoGroupGeography = new GeoGroupGeography();
                        $geoGroupGeography->setGeographyId($geo['id'])
                                ->setGeogroupId($geoGroup->getId());
                        $em->persist($geoGroupGeography);
                    }
                }
                $em->flush();
            }
            
            
            
        }
        print_r($data);

        echo "ll";
        return;


        $metaData = $em->getClassMetadata($entity);

        $columnNames = $metaData->getFieldNames();

        if ($data) {
            foreach ($data AS $row) {
                $exists = $em->getRepository($entity)->findOneBy(array($key => $row[$key]));
                if (!$exists) {
                    $this->getConnection()->insert($metaData->getTableName(), $row);
                }
            }
        }
    }

}

?>
