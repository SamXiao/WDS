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
use Application\Model\Member;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthDbTableAdapter;
use Zend\Authentication\Result;

class UserController extends AbstractActionController
{

    public function loginAction()
    {
        $form = $this->getServiceLocator()->get('Application\Form\LoginForm');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $member = new Member();
            $form->setInputFilter($member->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $result = $this->doAuthenticate($form->get('username')->getValue(), $form->get('password')->getValue());
                switch ($result->getCode()) {

                    case Result::SUCCESS:
                        /** do stuff for successful authentication **/
                        break;

                    case Result::FAILURE_IDENTITY_NOT_FOUND:
                        /** do stuff for nonexistent identity **/
                    case Result::FAILURE_CREDENTIAL_INVALID:
                        /** do stuff for invalid credential **/
                    default:
                        /** do stuff for other failure **/
                        $form->get( 'username')->setMessages( array('用户名或密码不正确'));
                        break;
                }
                foreach ($result->getMessages() as $message) {
                    echo "$message\n";
                }
            }
        }

        return array(
            'form' => $form
        );
    }

    protected function doAuthenticate($username, $password)
    {
        $auth = new AuthenticationService();

        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $authAdapter = new AuthDbTableAdapter($dbAdapter, 'core_member', 'username', 'password');
        $authAdapter->setIdentity($username);
        $authAdapter->setCredential($password);

        // Attempt authentication, saving the result
        $result = $auth->authenticate($authAdapter);
        return $result;
    }
}
