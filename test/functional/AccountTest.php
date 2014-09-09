<?php
require_once 'BaseTestCase.php';

class AccountTest extends BaseTestCase
{

    public function testAdmin()
    {
        $this->url('/admin/profile/profile/');
        $this->select($this->byName('industry'))->selectOptionByValue('BIOTEK');
        $this->waitUntil(function(){}, 10000);
    }


}
