<?php
namespace Betagento\IPDetection\Service\Provider;

use Betagento\IPDetection\Model\Constant as ModuleConstant;
use Betagento\IPDetection\Service\Provider\Maxmind\Solution\Factory as SolutionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Betagento\IPDetection\Service\Provider\Maxmind\Solution\SolutionInterface;

class Maxmind implements ProviderInterface{

    /**
     * @var array<string,string>
     */
    protected $_apiResponse;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var SolutionFactory
     */
    protected $solutionFactory;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param SolutionFactory $solutionFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SolutionFactory $solutionFactory
        
    ){
        $this->scopeConfig = $scopeConfig;
        $this->solutionFactory = $solutionFactory;
    }


    /**
    * @param string $ipAddress
    * @return array<string,string>
    */
    public function getGeoInfo(string $ipAddress): array
    {
        $response = $this->getResponse($ipAddress);
        return $response;        
    }

    /**
     * @param string $ipAddress
     * @return array<string,string>
     */
    protected function getResponse(string $ipAddress){

        if($this->_apiResponse == null){
            try{
                $this->_apiResponse = $this->getSolution()->execute($ipAddress);
            }catch(\Exception $ex){
                $this->_apiResponse = [];
                //@improve Should log here
            }
            
        }
        return $this->_apiResponse;
    }

    /**
     * Get Solution Name : Database File or Redis
     *
     * @return SolutionInterface
     */
    protected function getSolution(){
        $solutionName = $this->scopeConfig->getValue(ModuleConstant::XML_CONFIG_MAXMIND_TECHNICAL_SOLUTION);
        return $this->solutionFactory->get($solutionName);
        
    }
}