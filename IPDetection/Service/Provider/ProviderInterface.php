<?php
namespace Betagento\IPDetection\Service\Provider;

interface ProviderInterface {

    /**
    * @param string $ipAddress
    * @return array<string,string>
    */
    public function getGeoInfo(string $ipAddress): array;

}