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

class LoadWDIDataCommand extends ConnectionAwareCommand {

    protected $geographies = array();
    protected $indicators = array();

    protected function configure() {
        $this
                ->setName('load:wdidata')
                ->addArgument(
                        'file', InputArgument::REQUIRED, 'File'
                )
                ->addArgument(
                        'parameter', InputArgument::REQUIRED, 'eg wdi.import'
                )
                ->setDescription('Load WDI data')
        ;
    }

    /**
     * 
     * @return array
     */
    protected function getGeographyIdByCode3($code) {
        if (!$this->geographies) {
            $this->geographies = array();
            $entities = $this->getEntityManager()->getRepository('AEMRMarketResearchBundle:Geography')->findAll();

            if ($entities) {
                foreach ($entities AS $entity) {
                    $this->geographies[$entity->getCode3()] = $entity->getId();
                }
            }
        }

        if (isset($this->geographies[$code])) {
            return $this->geographies[$code];
        }
        throw new \Exception('Country not found : ' . $code);
    }

    /**
     * 
     * @return array
     */
    protected function getIndicatorIdByCode($code) {
        if (!$this->indicators) {
            $this->indicators = array();
            $entities = $this->getEntityManager()->getRepository('AEMRMarketResearchBundle:GeoIndicator')->findAll();

            if ($entities) {
                foreach ($entities AS $entity) {
                    $this->indicators[$entity->getCode()] = $entity->getId();
                }
            }
        }
        if (isset($this->indicators[$code])) {
            return $this->indicators[$code];
        }
        throw new \Exception('Indicator not found : ' . $code);
    }

    protected function getConfig($parameter) {
        return $this->getContainer()->getParameter($parameter);
    }

    protected function getData($header, $data) {
        $return = array();
        foreach ($header AS $column => $key) {
            if (isset($data[$key])) {
                $return[$column] = $data[$key];
            }
        }
        return $return;
    }

    protected function createSeries($row, $data, $periods) {
        $return = array();
        foreach ($periods AS $period) {
            if (isset($data[$period])) {
                $line = $row;
                $line['date'] = $period;
                $line['value'] = $data[$period];
                $return[] = $line;
            }
        }
        return $return;
    }

    /**
     * /var/www/aitools/web/uploads/term_properties/
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->setInsertLimit(10);
        $filePath = $input->getArgument('file');
        $parameter = $input->getArgument('parameter');

        $em = $this->getEntityManager();
        $config = $this->getConfig($parameter);

        $geoGroupSeriesEntity = 'AEMRMarketResearchBundle:GeoIndicatorSeries';
        $table = $em->getClassMetadata($geoGroupSeriesEntity)->getTableName();



        $file = new \SplFileObject($filePath);
        $i = 0;
        $header = array_flip($file->fgetcsv());
        $rows = 0;
        while (!$file->eof()) {

            try {
                $data = $this->getData($header, $file->fgetcsv());
                $row = array();

                if (isset($data[$config['country_code_column']]) && isset($data[$config['indicator_code_column']])) {

                    if (isset($config['indicators']) && !in_array($data[$config['indicator_code_column']], $config['indicators'])) {
                        continue;
                    }

                    $row['geoindicator_id'] = (int) $this->getIndicatorIdByCode($data[$config['indicator_code_column']]);
                    $row['geography_id'] = (int) $this->getGeographyIdByCode3($data[$config['country_code_column']]);

                    $data = array_merge($data, $row);

                    $series = $this->createSeries($row, $data, $config['periods']);
                    // print_r($series);
                    if ($series) {
                        foreach ($series AS $insertRow) {
                            $rows++;
                            $conditions = array(
                                'geoindicator_id' => $insertRow['geoindicator_id'], 'geography_id' => $insertRow['geography_id'], 'date' => $insertRow['date']
                            );
                            $geoGroupSeries = $em->getRepository($geoGroupSeriesEntity)->findOneBy($conditions);
                            // print_r($insertRow);
                            if($geoGroupSeries) {
                                $this->replace($table, $insertRow, $conditions);
                                // echo "updateing \n";
                            } else {
                                $this->replace($table, $insertRow);
                            }
                            // $output->writeln("<info>saving ... </info>");
                            // $output->writeln($insertRow);
                            // print_r($data);
                            
                            $this->replace($table, $insertRow);
                        }
                    }
                }

                $i++;
                // $output->writeln($i);
                // print_r($data);
            } catch (\Exception $e) {
                $output->writeln("<error>" . $e->getMessage() . "</error>");
            }
        }
        if ($rows) {
            $this->replace($table, array(), array(), true);
        }
        $output->writeln($rows . "lines to write \n");
        // print_r($geographies);
        // $csvToTableConverter = new CsvToGeoGroupConverter();
        // $csvToTableConverter->setPath($file);
        // $csvToTableConverter->setGeographies($geographies);
        // $data = $csvToTableConverter->convert();


        print_r($config);

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
