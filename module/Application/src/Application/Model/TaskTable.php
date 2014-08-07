<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;
use Zend\Db\ResultSet\ResultSet;;

class TaskTable
{

    protected $serviceManager = null;

    protected $tableGateway = null;

    const TABLE_NAME = 'pm_task';

    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        $dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Project());
        $this->tableGateway = new TableGateway(self::TABLE_NAME, $dbAdapter, null, $resultSetPrototype);
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getTask()
    {
        $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
    }

    public function saveTask(Task $task)
    {
        $data = $task->toArray();
         $id = (int) $task->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getTask($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Album id does not exist');
             }
         }
    }

    public function deleteTask()
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }


}

