<?php

namespace Application\Model;

class Task
{

    public $id = '';

    public $title = '';

    public $summary = '';

    public $sprint_id = '';

    public $type = '';

    public $assign_member_id = '';

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        $this->summary = (!empty($data['summary'])) ? $data['summary'] : null;
        $this->sprint_id = (!empty($data['sprint_id'])) ? $data['sprint_id'] : null;
        $this->type = (!empty($data['type'])) ? $data['type'] : null;
        $this->assign_member_id = (!empty($data['assign_member_id'])) ? $data['assign_member_id'] : null;
    }

    public function toArray($data)
    {
        $data = array();
        (!empty($this->id)) ? $data['id'] = $this->id : null;
        (!empty($this->title)) ? $data['title'] = $this->title : null;
        (!empty($this->summary)) ? $data['summary'] = $this->summary : null;
        (!empty($this->sprint_id)) ? $data['sprint_id'] = $this->sprint_id : null;
        (!empty($this->type)) ? $data['type'] = $this->type : null;
        (!empty($this->assign_member_id)) ? $data['assign_member_id'] = $this->assign_member_id : null;
        return $data;
    }


}

