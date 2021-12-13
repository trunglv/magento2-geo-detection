<?php

namespace Betagento\IPDetection\Api;

interface GeolocationServiceInterface
{
    /**
     * Get GeoInfomation
     *
     * @param string $ipAddress
     * @param boolean $isCached
     * @return array<string,mixed>
     */
    public function getGeoInfo($ipAddress = NULL, $isCached = true);
}
