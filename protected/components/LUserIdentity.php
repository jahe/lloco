<?php

require_once(Yii::getPathOfAlias('application') . "/libs/password.php");

class LUserIdentity extends CUserIdentity
{
	private $_id;
    public function authenticate()
    {
        $c = new EMongoCriteria;
        $c->username('==', $this->username);
        //$record = User::model()->find(array('username' => $this->username));
        $record = User::model()->find($c);

        if ($record === null)
        {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
            $this->errorMessage = "Der Benutzername <strong>\"" . CHtml::encode($this->username) . "\"</strong> konnte leider nicht gefunden werden.";
        }
        //else if ($record->password !== md5($this->password))
        else if (!password_verify($this->password, $record->password))
        {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = "Das Passwort war leider falsch.";
        }
        else
        {
            $this->_id = $record->_id;
            $this->setState('userid', $record->_id);
            $this->setState('username', $record->username);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}
?>