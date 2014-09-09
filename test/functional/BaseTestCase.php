<?php

class BaseTestCase extends PHPUnit_Extensions_Selenium2TestCase
{
    public function getConfig(){
        $localConfig = array();
        if (file_exists(__DIR__ . 'config\config.local.php')){
            $localConfig = require __DIR__ . 'config\config.php';
        }
        $config = require __DIR__ . 'config\config.php';
        $config = array_merge($config,$localConfig);
        return $config;
    }
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        $config = $this->getConfig();

        $this->setBrowser($config['Browser']);
        if (isset($config['DesiredCapabilities'])){
            $this->setDesiredCapabilities($config['DesiredCapabilities']);
        }
//
        // TODO Auto-generated Test::setUp()
        $this->setSeleniumServerRequestsTimeout(50000);
        $this->setBrowserUrl($config['BrowserUrl']);
    }

    public function setUpPage(){
        $this->url('/account/logout');
        $this->login();
        $this->selectOrg();
    }

    public function login(){
        $this->url('/account/login');
        $this->assertStringEndsWith('login', $this->url());
        $email = $this->byId('LoginForm_email');
        $email->value('samxiaotj@gmail.com');
        $password = $this->byId('LoginForm_password');
        $password->value('password123');
        $submit = $this->byCssSelector('button[type=submit]');
        $submit->click();
    }

    public function selectOrg(){
        $orgId = 87;
//         $this->clickOnElement('profileDropDownList');
//         $this->byCssSelector('#profileDroppedDownList div[data-event="Modal::SelectOrganization"]')->click();
        $this->waitUntil(function($case){
            try {
                $case->byCssSelector('#modal select');
                return true;
            }catch (Exception $e){

            }
        },10000);
        $orgSelect = $this->select($this->byCssSelector('#modal select'));
        $orgSelect->selectOptionByValue($orgId);
        $this->byCssSelector('#modal button[type="submit"]')->click();
        $this->waitUntil(function($case){
            if ( strpos($case->url(), 'home/') ){
                return true;
            }
        },10000);
        $this->assertStringEndsWith('home/', $this->url());
    }




}
