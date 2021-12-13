<?php 
namespace Betagento\IPDetection\Model\Cache;

class Geo{
    /**
     * @param string $ipAddress
     * @return string|bool
     */
    public function getGeoInfo($ipAddress){
        return false;
    }

    /**
     * @param string $ipAddress
     * @param array<string,mixed> $geoInfo
     * @return bool
     */
    public function cache($ipAddress, $geoInfo){
        return true;
    }
}

