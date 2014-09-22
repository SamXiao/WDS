<?php
namespace Application\Model\Account;

use SamFramework\Model\AbstractModelMapper;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthDbTableAdapter;
use SamFramework\Core\App;

class UserAuthenticator extends AbstractModelMapper
{

    protected $userTable;

    public function getUserTable()
    {
        if (! $this->userTable) {
            $this->userTable = $this->getServiceLocator()->get('Application\Model\Account\UserTable');
        }

        return $this->userTable;
    }

    /**
     * Email | Username
     * Password
     *
     * @param string $identity
     * @param string $credential
     * @return boolean
     */
    public function doPasswordAuth($identity, $credential)
    {
        return $this->setIdentity("");
    }

    public function existWeiboAccount($token)
    {
        $table = $this->getUserTable();
        try {
            $user = $table->getUserByWeiBoToken($token);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     *
     * @param unknown $token
     * @return boolean
     */
    public function doWeiboAuth($token)
    {
        $table = $this->getUserTable();
        try {
            $user = $table->getUserByWeiBoToken($token);
            return $this->setIdentity($user);
            ;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function setIdentity(User $user)
    {
        $auth = new AuthenticationService();
        $storage = $auth->getStorage();
        $storage->write($user);
        return true;
    }
}

