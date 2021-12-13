<?php
namespace Betagento\IPDetection\Service\Provider\Maxmind\Solution;

interface SolutionInterface
{   
    /**
     * @param string $ipAddress
     * @return array<string,string>
     */
    public function execute($ipAddress);
   
}
