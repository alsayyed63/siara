<?php
namespace common\components;

use Google\Client;
use Yii;

class GoogleDrive
{
    private $_client;

    const SESSION_KEY="google_access_token";
    public function __construct()
    {
        $this->_client = new Client();
        $this->_client->setAuthConfig(Yii::getAlias('@frontend').'/config/client_secret.json');
        $this->_client->addScope(\Google\Service\Drive::DRIVE);
        $this->_client->setAccessType('offline');   
    }

    public function hasAccessToGoogleApi($token=null)
    {
        if($token)
            return $this->authenticatateToken($token);

        return $this->checkHasAccess();
    }

    public function getFiles()
    {
        $drive = new \Google\Service\Drive($this->_client);
        return $drive->files->listFiles(['fields'=>'*'])->getFiles();
    }

    public function getGoogleAuthUrl()
    {
        return $this->_client->createAuthUrl();
    }

    private function checkTokenValidity()
    {
        if($this->_client->isAccessTokenExpired())
        {
            if ($this->_client->getRefreshToken())
                return $this->authenticatateToken($this->_client->getRefreshToken())?true:false;
            else
                return false;
        }
        return true;
    }

    public function authenticatateToken($token)
    {
        $this->_client->fetchAccessTokenWithAuthCode($token);
        Yii::$app->session->set(self::SESSION_KEY,$this->_client->getAccessToken());
        return true;
    }

    private function checkHasAccess()
    {
        if (Yii::$app->session->get(self::SESSION_KEY)) {
            $this->_client->setAccessToken(Yii::$app->session->get(self::SESSION_KEY,''));
            return $this->checkTokenValidity();
        } else {
            return false;
        }
    }
}
