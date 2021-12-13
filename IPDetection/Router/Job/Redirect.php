<?php
namespace Betagento\IPDetection\Router\Job; 
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Controller\Store\SwitchAction\CookieManager;
use Magento\Store\Model\StoreSwitcherInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Betagento\IPDetection\Model\Constant as ConfigConstant;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\CookieManagerInterface as GlobalCookieManagerInterface;
use Betagento\IPDetection\Api\GeolocationServiceInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\HttpInterface as ResponseHttp;


class Redirect implements JobInterface{

    const COOKIE_NAME = 'v1_detected_country';
    
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var \Magento\Framework\App\ResponseFactory 
     */
    protected $responseFactory;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var CookieManager
     */
    protected $cookieManager;

    /**
     * @var StoreSwitcherInterface
     */
    protected $storeSwitcher;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var CookieMetadataFactory
     */
    protected $cookieMetadataFactory;
    
    /**
     * @var GlobalCookieManagerInterface
     */
    protected $globalcookieManager;

    /**
     * @var GeolocationServiceInterface
     */
    protected $geolocationService;

    /**
     * @var HttpRequest
     */
    protected $request;


    public function __construct(
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        UrlInterface $urlBuilder,
        CookieManager $cookieManager,
        StoreSwitcherInterface $storeSwitcher,
        ScopeConfigInterface $scopeConfig,
        CookieMetadataFactory $cookieMetadataFactory,
        GlobalCookieManagerInterface $globalcookieManager,
        GeolocationServiceInterface $geolocationService
    ) {
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->responseFactory = $responseFactory;
        $this->urlBuilder = $urlBuilder;
        $this->cookieManager = $cookieManager;
        $this->storeSwitcher = $storeSwitcher;
        $this->scopeConfig = $scopeConfig;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->globalcookieManager = $globalcookieManager;
        $this->geolocationService = $geolocationService;
    }

    /**
     * Do Redirect to a respective country website
     *
     * @param \Magento\Framework\App\Request\Http $request
     * @return void
     */
    public function execute(HttpRequest $request): void{
        if($this->scopeConfig->getValue(ConfigConstant::XML_CONFIG_ENABLED)){
            $this->request = $request;
            $countryStore  = $this->getStoreCodeFromCountry();
            if($countryStore == false){
                $countryStore = $this->getDefaultStore();
            }
            if($this->shouldRedirectTo()){   
                $this->redidect($this->getDefaultStore()); 
            }
        }
    }

    /**
     * Should Redirect
     *
     * @param boolean $isFound
     * @return boolean
     */
    protected function shouldRedirectTo($isFound = false){
        
        if($this->globalcookieManager->getCookie(self::COOKIE_NAME)){
            return false;     
        }else{
            $cookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata()
            ->setHttpOnly(false)
            ->setDuration(3600)
            ->setPath("/")
            ;
            $this->globalcookieManager->setPublicCookie(self::COOKIE_NAME, '1', $cookieMetadata);
        }

        if($this->request->getPathInfo() == '/stores/store/redirect/' || $this->request->getPathInfo() == '/stores/store/switch/'){
            return false;
        }        
        return true;
    }

    /**
     * Get Store Code 
     *
     * @return mixed
     */
    protected function getStoreCodeFromCountry(){       
        $geoInfo = $this->geolocationService->getGeoInfo();
        $countryCode = isset($geoInfo['country_code']) ? $geoInfo['country_code'] : '';
        $stores = $this->storeManager->getStores();
        foreach($stores as $store){
            $storeCountryCode = $this->scopeConfig->getValue(ConfigConstant::XML_CONFIG_COUNTRY_CODE_FOR_WEBSITE, ScopeInterface::SCOPE_STORES, $store->getCode());
            if($countryCode  === $storeCountryCode){
                return $store;
            }  
        }
        return false;
    }

    /**
     * Redirect
     *
     * @param \Magento\Store\Model\Store $store
     * @return void
     */
    protected function redidect($store){        
        $requestedUrlToRedirect = $store->getCurrentUrl(false);
        /**
         * @var \Magento\Store\Model\Store $currentStore
         */
        $currentStore = $this->storeManager->getStore();
        $redirectUrl = $this->storeSwitcher->switch($currentStore, $store, $requestedUrlToRedirect);
        /*
            If for safe => avoid redirect multile times  
        */
        $this->cookieManager->setCookieForStore($store);    
        
        if($requestedUrlToRedirect !== $currentStore->getCurrentUrl(false)){
            /**
             * @var ResponseHttp $response
             */
            $response = $this->responseFactory->create();
            $response->setRedirect($redirectUrl)->sendResponse();
            exit;
        }
    }

    /**
     * @return \Magento\Store\Model\Store
     */
    protected function getDefaultStore(){
        $seoStoreId = $this->scopeConfig->getValue(ConfigConstant::XML_CONFIG_DEFAULT_SEO_STORE);
        /**
         * @var \Magento\Store\Model\Store $defaultStore
         */
        $defaultStore = $this->storeManager->getStore($seoStoreId);
        //return $this->storeFactory->create()->load($seoStoreId);
        return $defaultStore;
    }
}