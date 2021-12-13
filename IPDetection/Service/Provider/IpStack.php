<?php
namespace Betagento\IPDetection\Service\Provider;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\Client\CurlFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Betagento\IPDetection\Model\Constant as ModuleConfig;

class IpStack implements ProviderInterface{

    /**
     * @var array<string,string>
     */
    protected $_apiResponse;

    /**
     * @var CurlFactory
     */
    protected $curlFactory;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param CurlFactory $curlFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        CurlFactory $curlFactory,
        ScopeConfigInterface $scopeConfig
        
    ){
        $this->curlFactory = $curlFactory;
        $this->scopeConfig = $scopeConfig;
    }
    /**
    * @param string $ipAddress
    * @return array<string,string>
    */
    public function getGeoInfo(string $ipAddress): array
    {      
        return $this->getResponse($ipAddress);
    }

    
    /**
     * Get Respone from IP-STACK server
     *
     * @param string $ipAddress
     * @return bool|array<string,string>
     */
    protected function getResponse(string $ipAddress){
        if($this->_apiResponse == NULL){
            $accessKey = $this->scopeConfig->getValue(ModuleConfig::XML_CONFIG_IPSTACK_PRIVATE_KEY);
            $requestUrl = 'http://api.ipstack.com/'.$ipAddress.'?access_key='.$accessKey.'';
            $curl = $this->curlFactory->create();
            try {
                $curl->get($requestUrl);
                $body = $curl->getBody();
                $this->_apiResponse = json_decode($body, true);
                
            } catch (\Exception $ex) {
                
            }
        }
        return $this->_apiResponse;
        
    }

}