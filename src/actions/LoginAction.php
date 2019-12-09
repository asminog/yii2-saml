<?php

namespace asminog\yii2saml\actions;

use Yii;

/**
 * This class provides action for initiating login process using Saml.
 */
class LoginAction extends BaseAction
{

    /**
     * Initiate login process using Saml.
     * @return void
     */
    public function run()
    {
        $this->samlInstance->login((!empty(Yii::$app->user->returnUrl) ? Yii::$app->user->returnUrl : Yii::$app->homeUrl));
    }

}
