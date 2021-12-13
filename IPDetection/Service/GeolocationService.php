<?php

namespace Betagento\IPDetection\Service;

use Exception;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\HTTP\Client\CurlFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Betagento\IPDetection\Api\GeolocationServiceInterface;
use Betagento\IPDetection\Model\Cache\Geo as IPCache;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Betagento\IPDetection\Model\Constant as ModuleConstant;
use Betagento\IPDetection\Service\Provider\ProviderInterface;

class GeolocationService implements GeolocationServiceInterface
{
    /**
     * @var DirectoryList
     */
    protected $dir;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;
    
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * ['']
     *
     * @var array<string,string>|bool
     */
    protected $geoInfo = false;

    /**
     * @var ProviderInterface
     */
    protected $geoService;

    /**
     * @var string
     */
    protected $serviceCode = '';

    /**
     * Provider Factory
     *
     * @var \Betagento\IPDetection\Service\ProviderFactory
     */
    protected $geoServiceFactory;

    /**
     * @var IPCache
     */
    protected $ipCache;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

   /**
    * @param DirectoryList $dir
    * @param LoggerInterface $logger
    * @param ResourceConnection $resourceConnection
    * @param StoreManagerInterface $storeManager
    * @param \Betagento\IPDetection\Service\ProviderFactory $geoServiceFactory
    * @param IPCache $ipCache
    * @param ScopeConfigInterface $scopeConfig
    */
    public function __construct(
        DirectoryList $dir,
        LoggerInterface $logger,
        ResourceConnection $resourceConnection,
        StoreManagerInterface $storeManager,
        \Betagento\IPDetection\Service\ProviderFactory $geoServiceFactory,
        IPCache $ipCache,
        ScopeConfigInterface $scopeConfig
        
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->logger = $logger;
        $this->dir = $dir;
        $this->storeManager = $storeManager;
        $this->geoServiceFactory = $geoServiceFactory;
        $this->ipCache = $ipCache;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get GeoInformation
     *
     * @param string $ipAddress
     * @param boolean $isCached
     * @return array<string,string>
     */
    public function getGeoInfo($ipAddress = NULL, $isCached = true){

        if($this->geoInfo === false){
            if($ipAddress === NULL)
                $ipAddress = $this->getClientIp();
            
            if($isCached && $cache = $this->ipCache->getGeoInfo($ipAddress)){
                return json_decode($cache, true);
            }  
            try{
                $this->geoInfo = $this->getGeoService()->getGeoInfo($ipAddress);
                if($isCached !== false)
                    $this->ipCache->cache($ipAddress, $this->geoInfo);
            }catch(\Exception $ex){
                //should log here
                return [];
            }
            
        }
        return $this->geoInfo;
    }

    /**
     * Get Geo service provider
     *
     * @return ProviderInterface
     */
    protected function getGeoService(){
        if($this->geoService == NULL){
            $serviceCode = $this->scopeConfig->getValue(ModuleConstant::XML_CONFIG_GEO_SERVICE);
            $this->geoService =  $this->geoServiceFactory->get($serviceCode);   
        }
        return $this->geoService;
    }

    /**
     * Set Service code
     *
     * @param string $serviceCode
     * @return void
     */
    public function setServiceCode($serviceCode){
        $this->serviceCode = $serviceCode;
    }

    /**
     * Get Client IP
     *
     * @return string
     */
    public function getClientIp()
    {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        }elseif (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        }else {
            $ipaddress = 'UNKNOWN';
        }
        $ipaddress = explode(",", $ipaddress);
        $ipaddress = trim($ipaddress[0]);
        return $ipaddress;
    }
}
