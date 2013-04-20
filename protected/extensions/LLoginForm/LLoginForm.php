<?php
class LLoginForm extends CWidget
{
    public function init()
    {
        // Diese Methode wird bei CController::beginWidget() aufgerufen
    }

    public function run()
    {
        // Diese Methode wird bei CController::endWidget() aufgerufen
        $this->render('loginForm');
    }
}
?>