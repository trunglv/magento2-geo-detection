<?php
namespace Betagento\IPDetection\Service\Provider;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\Client\CurlFactory;
use Betagento\IPDetection\Model\Constant;

class GeoPlugin implements ProviderInterface{

    /**
     * @var CurlFactory
     */
    protected $curlFactory;

    /**
     * @param CurlFactory $curlFactory
     */
    public function __construct(
        CurlFactory $curlFactory
        
    ){
        $this->curlFactory = $curlFactory;
    }
    
    /**
    * @param string $ipAddress
    * @param bool $isCached
    * @return array<string,string>
    */
    public function getGeoInfo($ipAddress = NULL, $isCached = true): array
    {
        $requestUrl = Constant::GEOPLUGIN_SERVICE_URL.'?ip=' . $ipAddress;
        $curl = $this->curlFactory->create();
        $countryCode = '';
        try {
            $curl->get($requestUrl);
            $body = $curl->getBody();
            $response = json_decode($body, true);
            if (isset($response['geoplugin_countryCode'])) {
                $countryCode = $response['geoplugin_countryCode'];
            }
        } catch (\Exception $e) {
        }
        return [
            'country_code' => $countryCode
        ];
    }
}