<?php
namespace Betagento\IPDetection\Service;
use Betagento\IPDetection\Service\Provider\ProviderInterface;
use Magento\Framework\ObjectManagerInterface;
class ProviderFactory {

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var array<string,string>
     */
    protected $providers;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param array<string,string> $providers
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        array $providers = []
    ){

        $this->providers = $providers;
        $this->objectManager = $objectManager;

    }

    /**
     * @param string $providerName
     * @return ProviderInterface
     * @throws \Exception
     */
    public function get($providerName){
        if(isset($this->providers[$providerName]) && $providerClassName =  $this->providers[$providerName]){
            return $this->objectManager->get($providerClassName);
        }
        throw new \Exception("A provider service is not found for IP Detection");
    }
}