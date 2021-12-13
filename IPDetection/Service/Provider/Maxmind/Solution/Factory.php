<?php 
namespace Betagento\IPDetection\Service\Provider\Maxmind\Solution;
use Betagento\IPDetection\Service\Provider\Maxmind\Solution\SolutionInterface;

use function PHPUnit\Framework\throwException;

class Factory {
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var array<string,string>
     */
    protected $solutions;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param array<string,string> $solutions
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $solutions = []
    ){

        $this->solutions = $solutions;
        $this->objectManager = $objectManager;

    }

    /**
     * Get Solution business
     *
     * @param string $solutionName
     * @return SolutionInterface
     * @throws \Exception
     */
    public function get($solutionName){

        if($solutionClassName =  $this->solutions[$solutionName]){
            return $this->objectManager->get($solutionClassName);
        }
        
        throw new \Exception("Can not find a solution business for Maxmind");
    }

}