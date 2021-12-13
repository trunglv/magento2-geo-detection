<?php
namespace Betagento\IPDetection\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Betagento\IPDetection\Api\GeolocationServiceInterface;
use Betagento\IPDetection\Model\Constant as ConfigConstant;

class Debug extends Template {

    /**
     * @var GeolocationServiceInterface
     */
    protected $geoService;
    
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param GeolocationServiceInterface $geoService
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array<string,mixed> $data
     * @return void
     */
    public function __construct(
        GeolocationServiceInterface $geoService,
        ScopeConfigInterface $scopeConfig,
        Context $context,
        array $data = []
    )
    {   
        $this->geoService = $geoService;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * @return array<string,mixed>
     */
    public function getGeoInfo(){
        $executionStartTime = microtime(true);
        $geoInfo = $this->geoService->getGeoInfo();
        $executionEndTime = microtime(true);
        $seconds = $executionEndTime - $executionStartTime;
        //Print it out
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);
        $timeFormat = sprintf('%02d:%02d:%02d (%s)', $hours, $mins, $secs, $seconds);
        $geoInfo['executed_time'] = $timeFormat;
        return $geoInfo;
    }

    /**
     * @return boolean
     */
    public function isEnabled(){
        if($this->scopeConfig->getValue(ConfigConstant::XML_CONFIG_ENABLED) && $this->_scopeConfig->getValue(ConfigConstant::XML_CONFIG_SHOW_DEBUG_MESSAGE)){
            return true;
        }
        return false;
    }
}