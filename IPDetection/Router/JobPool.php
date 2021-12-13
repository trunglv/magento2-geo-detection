<?php
namespace Betagento\IPDetection\Router;

use Magento\Framework\App\Request\Http;

class JobPool{
    
    /**
     * Job pool -- where contains jobs that be executed before a router detect a country
     *
     * @var array<string,\Betagento\IPDetection\Router\Job\JobInterface> $jobs
     */
    protected $jobs;

    /**
     * @param array<string,\Betagento\IPDetection\Router\Job\JobInterface> $jobs
     */
    public function __construct(
        $jobs = []
    )
    {
        $this->jobs = $jobs;
    }

    /**
     * Execute all of jobs
     *
     * @param \Magento\Framework\App\Request\Http $request
     * @return void
     */
    public function execute(Http $request){
        foreach($this->jobs as $job){
            if($job instanceof \Betagento\IPDetection\Router\Job\JobInterface){
                $job->execute($request);
            }
            
        }
    }
}