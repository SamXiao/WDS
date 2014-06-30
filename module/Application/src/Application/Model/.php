<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class MemberTable
{

    public $tableGateway = null;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getMember()
    {
        $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
    }

    public function saveMember()
    {
        $data = Member->toArray();
         $id = (int) Member->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getMember($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Album id does not exist');
             }
         }
    }

    public function deleteMember()
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }


}

