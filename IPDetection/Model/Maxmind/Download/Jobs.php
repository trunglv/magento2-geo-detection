<?php
namespace Betagento\IPDetection\Model\Maxmind\Download;

class Jobs {
    /**
     * @var array<string,object>
     */
    protected $jobs;

    /**
     * @param array<string,object> $jobs
     */
    public function __construct(
        $jobs = []
    )
    {
        $this->jobs = $jobs;
    }

    /**
     * @return void
     */
    public function execute(){
        foreach($this->jobs as $job){
            $job->execute();
        }
    }
}