<?php 
namespace Betagento\IPDetection\Model\Maxmind;

use Betagento\IPDetection\Model\Maxmind\Download\Jobs as DownloadJobs;

class Download {

    /**
     * @var DownloadJobs
     */
    protected $downloadJobs;

    public function __construct(
        DownloadJobs $downloadJobs
    ){       
       $this->downloadJobs = $downloadJobs;
    }

    /**
     * @return void
     */
    public function execute(){
        $this->downloadJobs->execute();
    }
}