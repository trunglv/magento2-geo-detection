<?php

namespace Betagento\IPDetection\Plugin\Session;

use Magento\Framework\Session\SessionManager;
use Magento\Framework\Session\Storage;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\StoreSwitcher\ManageStoreCookie;
use Psr\Log\LoggerInterface;
use Betagento\IPDetection\Api\GeolocationServiceInterface;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Betagento\IPDetection\Model\Constant as ConfigConstant;
use Magento\Store\Model\ScopeInterface;


class SessionManagerPlugin
{
    /**
     * @var GeolocationServiceInterface
     */
    protected $geolocationService;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var ManageStoreCookie
     */
    protected $manageStoreCookie;
    /**
     * @var Storage
     */
    protected $storage;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        ManageStoreCookie $manageStoreCookie,
        UrlInterface $url,
        StoreManagerInterface $storeManager,
        GeolocationServiceInterface $geolocationService,
        Storage $storage,
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig
        
    )
    {
        $this->geolocationService = $geolocationService;
        $this->storage = $storage;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->url = $url;
        $this->manageStoreCookie = $manageStoreCookie;
        $this->scopeConfig = $scopeConfig;
        
    }

    /**
     * After plugin for start() function of SessionManager
     * @param SessionManager $subject
     * @param SessionManager $result
     * @return SessionManager
     */
    public function afterStart(SessionManager $subject, SessionManager $result)
    {   
        if($this->scopeConfig->getValue(ConfigConstant::XML_CONFIG_ENABLED)){
            // get stored code from session storage
            $countryCode = $this->storage->getData('country_code');
            $zipCode = $this->storage->getData('zip_code');
            $geoInfo = $this->geolocationService->getGeoInfo();
            if (!isset($countryCode)) {
                $geoInfo = $this->geolocationService->getGeoInfo();  
                $this->storage->setData('country_code', isset($geoInfo['country_code']) ? $geoInfo['country_code'] : '');
            }
            if (!isset($zipCode)) {
                $geoInfo = $this->geolocationService->getGeoInfo();  
                $this->storage->setData('zip_code', isset($geoInfo['zip_code']) ? $geoInfo['zip_code'] : '');
            }
        }
        return $result;
    }

    

}
