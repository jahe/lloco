<?php
class LUserIdentity extends CUserIdentity
{
	private $_id;
    public function authenticate()
    {
        $record = User::model()->findByAttributes(array('username' => $this->username));

        if ($record === null)
        {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
            $this->errorMessage = "Der Benutzername <strong>\"" . CHtml::encode($this->username) . "\"</strong> konnte leider nicht gefunden werden.";
        }
        //else if ($record->password !== md5($this->password))
        else if ($record->password !== $this->password)
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