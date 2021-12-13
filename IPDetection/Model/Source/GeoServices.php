<?php 
namespace Betagento\IPDetection\Model\Source;
use Betagento\IPDetection\Service\Provider\ProviderInterface;

class GeoServices {

    /**
     * @var array<string,ProviderInterface>
     */
    protected $services;

    /**
     * @param array<string,ProviderInterface> $services
     */
    public function __construct(array $services = array() ) {
        $this->services = $services;
    }

    /**
     * @return array<mixed>
     */
    public function toOptionArray()
    {
        $options = array(); 
        foreach($this->services as $key => $value){
            $options[] = [
                'value' => $key,
                'label' => $value
            ];
        }
        return $options;
    }

}