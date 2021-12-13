<?php 
namespace Betagento\IPDetection\Model\Source\Maxmind;

class Solutions {
    
    /**
     * @var array<string,string>
     */
    protected $solutions;
    
    /**
     * @param array<string,string> $solutions
     */
    public function __construct(array $solutions = array() ) {
        $this->solutions = $solutions;
    }

    /**
     * @return array<mixed>
     */
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
