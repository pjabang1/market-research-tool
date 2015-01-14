<?php

namespace AEMR\Bundle\MarketResearchBundle\Command;

ini_set('memory_limit', '200M');
use AEMR\Bundle\MarketResearchBundle\Command\ConnectionAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Hibu\OM5Bundle\Entity\TermTree;
use AEMR\Bundle\MarketResearchBundle\DataSource\Converter\CsvToTableConverter;

class LoadCsvCommand extends ConnectionAwareCommand {

    protected function configure() {
        $this
                ->setName('load:csv')
                ->addArgument(
                        'file', InputArgument::REQUIRED, 'File'
                )
                ->addArgument(
                        'entity', InputArgument::REQUIRED, 'Entity'
                )
                ->addArgument(
                        'key', InputArgument::REQUIRED, 'Key'
                )
                ->setDescription('Load Csv')

        ;
    }

    /**
     * /var/www/aitools/web/uploads/term_properties/
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        
        $file = $input->getArgument('file');
        $entity = $input->getArgument('entity');
        $key = $input->getArgument('key');
        
        $em = $this->getEntityManager();
        $metaData = $em->getClassMetadata($entity);
        
        $columnNames = $metaData->getFieldNames();
        $csvToTableConverter = new CsvToTableConverter();
        $csvToTableConverter->setPath($file);
        
        
        $data = $csvToTableConverter->convert($columnNames);
        
        if($data) {
            foreach($data AS $row) {
                $exists = $em->getRepository($entity)->findOneBy(array($key => $row[$key]));
                if(!$exists) {
                    $this->getConnection()->insert($metaData->getTableName(), $row);
                }
            }
        }
        
        
    }

}

?>
