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
use Application\Form\LoginForm;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthDbTableAdapter;

class LoginController extends AbstractActionController {
	public function indexAction() {
		$form = new LoginForm ();
		$form->get ( 'submit' )->setValue ( 'Add' );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			
			if ($this->doAuth ()->isValid ()) {
				
				// Authentication succeeded; the identity ($username) is stored
				// in the session
				// $result->getIdentity() === $auth->getIdentity()
				// $result->getIdentity() === $username
			} else {
				// Authentication failed; print the reasons why
				foreach ( $result->getMessages () as $message ) {
					echo "$message\n";
				}
			}
		}
		
		return array (
				'form' => $form 
		);
	}
	protected function doAuth($identity, $credential) {
		$dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Adapter' );
		$auth = new AuthenticationService ();
		$authAdapter = new AuthDbTableAdapter ( $dbAdapter, 'core_member', 'username', 'password' );
		$authAdapter->setIdentity ( $identity );
		$authAdapter->setCredential ( $credential );
		
		// Attempt authentication, saving the result
		$result = $auth->authenticate ( $authAdapter );
		return $result;
	}
}
