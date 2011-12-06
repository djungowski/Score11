<?php
namespace Score11\Api;

require_once LIBPATH . '/Zend/Http/Client.php';
require_once LIBPATH . '/Zend/Http/Client/Adapter/Curl.php';

/**
 * @TODO: Unit testen ggf? Ist etwas schwierig wegen dem CURL Aufruf...
 * 
 * @author djungowski
 * 
 */
class Call
{
    private $_apiConfig;
    
    private $_method;
    
    private $_format = 'json';
    
    private $_client;
    
    private $_url;
    
    /**
     * API Call fuer bestimmte Methode erzeugen
     * Methode ist z.b.
     *  - comment/latest
     *  - movie/40086
     *  
     *  Fuehrenden Slash nicht mit angeben!
     *  
     * Der REST Dienst unterstuetzt die folgenden Formate:
     *  - json
     *  - xml
     * 
     * @param String $method
     * @param String $format
     */
    public function __construct($method, $format = 'json')
    {
        $this->_method = $method;
        $this->_format = 'json';
        $this->readApiConfig();
        $this->createBaseUrl();
        $this->createHttpClient();
    }
    
    /**
     * API Konfiguration auslesen
     * 
     */
    private function readApiConfig()
    {
        $this->_apiConfig = \Zend_Registry::get('api');
    }
    
    private function createHttpClient()
    {
        $this->_client = new \Zend_Http_Client($this->_url);
        $adapter = new \Zend_Http_Client_Adapter_Curl();
        // Authentifierung selber am Adapter setzen, da wird Digest Authentizifierung
        // brauchen, die Zend_Http_Client selber noch nicht unterstuetzt
        // sonst koennte man $this->client->setAuth() nutzen
        $adapter->setCurlOption(CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        $userpwd = $this->_apiConfig->api->user . ':' . $this->_apiConfig->api->key;
        $adapter->setCurlOption(CURLOPT_USERPWD, $userpwd);
        $this->_client->setAdapter($adapter);
    }
    
    private function createBaseUrl()
    {
        $this->_url = sprintf('%s%s.%s', $this->_apiConfig->api->host, $this->_method, $this->_format);
    }
    
    private function convertResponse(\Zend_Http_Response $response)
    {
        $body = $response->getBody();
        $body = json_decode($body, true);
        return $body;
    }
    
    public function get($params = array())
    {
        $this->_client->setParameterGet($params);
        $response = $this->_client->request('GET');
        return $this->convertResponse($response);
    }
    
    public function post($params = array())
    {
        
    }
    
    public function push($params = array())
    {
        
    }
    
    public function delete($params = array())
    {
        
    }
}