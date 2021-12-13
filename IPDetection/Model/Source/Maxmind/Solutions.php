<?php 
namespace Betagento\IPDetection\Model\Source\Maxmind;

class Solutions {
    
    public function __construct(array $solutions = array() ) {
        $this->solutions = $solutions;
    }


    public function toOptionArray()
    {
       
        $options = array(); 
        foreach($this->solutions as $key => $value){
            $options[] = [
                'value' => $key,
                'label' => $value
            ];
        }
        return $options;
    }

}