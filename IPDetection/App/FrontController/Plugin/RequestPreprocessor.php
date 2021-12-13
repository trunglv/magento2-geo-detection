<?php
namespace Betagento\IPDetection\App\FrontController\Plugin;

use Betagento\IPDetection\Router\JobPool;
/**
 * Class RequestPreprocessor
 */
class RequestPreprocessor
{
    /**
     * @var JobPool
     */
    private $ipDetectionjobPool;

    /**
     * @param JobPool $ipDetectionjobPool
     */
    public function __construct(
       JobPool $ipDetectionjobPool
    ) {
        
        $this->ipDetectionjobPool = $ipDetectionjobPool;
    }
    
    /**
     * @param \Magento\Framework\App\FrontController $subject
     * @param \Closure $proceed
     * @param \Magento\Framework\App\Request\Http $request
     * @return \Magento\Framework\App\ResponseInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundDispatch(
        \Magento\Framework\App\FrontController $subject,
        \Closure $proceed,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->ipDetectionjobPool->execute($request);
        return $proceed($request);
    }
    
}