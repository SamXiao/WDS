<?php
namespace Application\Model\Account;

use SamFramework\Model\AbstractModel;
use Zend\InputFilter\InputFilter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthDbTableAdapter;
use Zend\Authentication\Result;
use Application\Form\LoginForm;
use SamFramework\Core\App;

class UserAuth extends AbstractModel
{


    public $name = '';

    public $email = '';

    public $password = '';

    public $create_time = '';

    public $update_time = '';

    public $weibo_code = '';

    public $weibo_name = '';

    public $weibo_expiry = '';





    public function exchangeArray(array $array)
    {
        $this->id = (isset($array['id'])) ? $array['id'] : $this->id;
        $this->name = (isset($array['name'])) ? $array['name'] : $this->name;
        $this->email = (isset($array['email'])) ? $array['email'] : $this->email;
        $this->password = (isset($array['password'])) ? $array['password'] : $this->password;
        $this->weibo_code = (isset($array['weibo_code'])) ? $array['weibo_code'] : $this->weibo_code;
        $this->weibo_name  = (isset($array['weibo_name'])) ? $array['weibo_name'] : $this->weibo_name;
        $this->weibo_expiry  = (isset($array['weibo_expiry'])) ? $array['weibo_expiry'] : $this->weibo_expiry;
    }

    public function getArrayCopy()
    {
        $data = array(
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'weibo_code' => $this->weibo_code,
            'weibo_name' => $this->weibo_name,
            'weibo_expiry' => $this->weibo_expiry,
        );
        return $data;
    }


    public static function doAuthenticate($username, $password)
    {
        $auth = new AuthenticationService();

        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $authAdapter = new AuthDbTableAdapter($dbAdapter, 'user', 'username', 'password', "MD5(CONCAT('staticSalt', ?, create_time))");
        $authAdapter->setIdentity($username);
        $authAdapter->setCredential($password);

        // Attempt authentication, saving the result
        $result = $auth->authenticate($authAdapter);
        $storage = $auth->getStorage();
        $storage->write($authAdapter->getResultRowObject(null, 'password'));
        return $result;
    }

}

