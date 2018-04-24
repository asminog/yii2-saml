<?php

namespace asminog\yii2saml;

use Yii;
use yii\base\Object;

/**
 * This class wraps OneLogin_Saml2_Auth class by creating an instance of that class using configurations specified in configFileName variable inside @app/config folder.
 */
class Saml extends Object
{

    /**
     * The file in which contains OneLogin_Saml2_Auth configurations.
     */
    public $configFileName = '@app/config/saml.php';

    /**
     * OneLogin_Saml2_Auth instance.
     * @var \OneLogin_Saml2_Auth
     */
    private $instance;

    /**
     * Configurations for OneLogin_Saml2_Auth.
     * @var array
     */
    public $config;

    public function init()
    {
        parent::init();

        if (!isset($this->config)) {
            $configFile = Yii::getAlias($this->configFileName);

            $this->config = require($configFile);
        }

        $this->instance = new \OneLogin_Saml2_Auth($this->config);
    }

    /**
     * Call the login method on OneLogin_Saml2_Auth.
     */
    public function login($returnTo = null, $parameters = array(), $forceAuthn = false, $isPassive = false)
    {
        return $this->instance->login($returnTo, $parameters, $forceAuthn, $isPassive);
    }

    /**
     * Call the logout method on OneLogin_Saml2_Auth.
     */
    public function logout($returnTo = null, $parameters = array(), $nameId = null, $sessionIndex = null)
    {
        return $this->instance->logout($returnTo, $parameters, $nameId, $sessionIndex);
    }

    /**
     * Call the getAttributes method on OneLogin_Saml2_Auth.
     */
    public function getAttributes()
    {
        return $this->instance->getAttributes();
    }

    /**
     * Call the getAttribute method on OneLogin_Saml2_Auth.
     */
    public function getAttribute($name)
    {
        return $this->instance->getAttribute($name);
    }

    /**
     * Returns the metadata of this Service Provider in xml.
     * @return string Metadata in xml
     * @throws \Exception
     * @throws \OneLogin_Saml2_Error
     */
    public function getMetadata()
    {
        $samlSettings = new \OneLogin_Saml2_Settings($this->config, true);
        $metadata = $samlSettings->getSPMetadata();

        $errors = $samlSettings->validateMetadata($metadata);
        if (!empty($errors)) {
            throw new \Exception('Invalid Metadata Service Provider');
        }

        return $metadata;
    }

    /**
     * Call the processResponse method on OneLogin_Saml2_Auth.
     */
    public function processResponse()
    {
        $this->instance->processResponse();
    }

    public function processSLO()
    {
        $this->instance->processSLO();   
    }

    /**
     * Call the getErrors method on OneLogin_Saml2_Auth.
     */
    public function getErrors()
    {
        return $this->instance->getErrors();
    }

    /**
     * Call the getLastErrorReason method on OneLogin_Saml2_Auth.
     */
    public function getLastErrorReason()
    {
        return $this->instance->getLastErrorReason();
    }

    /**
     * Check if debug is enabled on OneLogin_Saml2_Auth.
     */
    public function isDebugActive()
    {
        $samlSettings = $this->instance->getSettings();
        return $samlSettings->isDebugActive();
    }
}
