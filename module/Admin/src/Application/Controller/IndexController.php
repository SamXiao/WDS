<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthDbTableAdapter;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Application\Model\B;
use Application\Model\A;
use Zend\Di\Di;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function authAction()
    {

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $auth = new AuthenticationService();
        $authAdapter = new AuthDbTableAdapter($dbAdapter, 'core_member', 'username', 'password');
        $authAdapter->setIdentity('test');
        $authAdapter->setCredential('password');
        // Attempt authentication, saving the result
        $result = $auth->authenticate($authAdapter);
        
        if (!$result->isValid()) {
            // Authentication failed; print the reasons why
            foreach ($result->getMessages() as $message) {
                echo "$message\n";
            }
        } else {
            // Authentication succeeded; the identity ($username) is stored
            // in the session
            // $result->getIdentity() === $auth->getIdentity()
            // $result->getIdentity() === $username
        }
        return false;
    }

    public function diAction()
    {
        $di = new Di();
        $b = $di->get('Application\Model\B');
        var_dump($b);
        return false;
    }
}
