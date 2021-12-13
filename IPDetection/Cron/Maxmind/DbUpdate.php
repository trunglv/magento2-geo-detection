<?php 
namespace Betagento\IPDetection\Cron\Maxmind;
use Magento\Framework\App\ObjectManager as ObjectManager;
use Betagento\IPDetection\Model\Maxmind\Download as MaxmindDownload;

class DbUpdate {
    /**
     * MaxmindDownload
     * @var MaxmindDownload
     */
    protected $downloadProcess;

    public function __construct(
        MaxmindDownload $downloadProcess
    ){
        $this->downloadProcess = $downloadProcess;
    }
    /**
     * @return void
     */
    public function execute(){
        $this->downloadProcess->execute();
    }
}