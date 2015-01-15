<?php

namespace AEMR\Bundle\MarketResearchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class ConnectionAwareCommand extends ContainerAwareCommand {

    private $connection;
    private $entityManager;
    protected $insertCounter = 0;
    protected $insertLimit = 5000;

    public function getInsertCounter() {
        return $this->insertCounter;
    }

    public function setInsertCounter($insertCounter) {
        $this->insertCounter = $insertCounter;
    }

    public function getInsertLimit() {
        return $this->insertLimit;
    }

    public function setInsertLimit($insertLimit) {
        $this->insertLimit = $insertLimit;
    }

    public function getEntityManager() {
        if (!$this->entityManager) {
            $this->entityManager = $this->getContainer()->get('doctrine')->getManager();
        }
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {

        $this->entityManager = $entityManager;
        return $this;
    }

    public function getConnection() {
        if (!$this->connection) {
            $this->connection = $this->getContainer()->get("database_connection");
            $this->connection->getConfiguration()->setSQLLogger();
        }
        return $this->connection;
    }

    public function setConnection($connection) {
        $this->connection = $connection;
    }

    protected function update($table, $line, $comit = false) {


        $conn = $this->getConnection();

        if ($this->insertCounter == 0) {
            $conn->beginTransaction();
        }

        if ($line) {
            try {
                $conn->insert($table, $line);
                $this->insertCounter++;
            } catch (\Exception $e) {
                echo $e->getMessage() . "\n";
                // print_r($line);
            }
        }

        if (!$comit && $this->insertCounter >= $this->insertLimit) {
            echo "commiting \n";
            $conn->commit();
            $this->insertCounter = 0;
        }

        if ($comit && $this->insertCounter > 0) {
            echo "final commit \n";
            $conn->commit();
        }
    }

    protected function replace($table, $line, $conditions = array(), $comit = false) {


        $conn = $this->getConnection();

        if ($this->insertCounter == 0) {
            // $conn->beginTransaction();
        }

        if ($line) {

            try {
                if ($conditions) {
                    echo "updating \n";
                    $conn->update($table, $line, $conditions);
                } else {
                    $conn->insert($table, $line);
                    echo "inserting \n";
                }
                $this->insertCounter++;
            } catch (\Exception $e) {
                // echo $e->getMessage() . "\n";
                // print_r($line);
            }
        }

        if (!$comit && $this->insertCounter >= $this->insertLimit) {
            echo "commiting \n";
            // $conn->commit();
            $this->insertCounter = 0;
        }

        if ($comit && $this->insertCounter > 0) {
            echo "final commit \n";
            // $conn->commit();
        }
    }

}

?>
