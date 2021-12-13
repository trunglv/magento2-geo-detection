<?php
namespace Betagento\IPDetection\Model\Maxmind\Download;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Betagento\IPDetection\Model\Constant as ModuleConstant;

class Database {
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    
    /**
     * @param Filesystem $fileSystem
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Filesystem $fileSystem,
        ScopeConfigInterface $scopeConfig
    ){
        $this->fileSystem = $fileSystem;  
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return void
     */
    public function execute(){
        try{
            stream_wrapper_restore('phar');
            $mediaAbsolutePath = $this->getMediaAbsolutePath();
            $maxMindDatabaseDir = $mediaAbsolutePath .'maxmind' . DIRECTORY_SEPARATOR . 'db';
            if(!file_exists($mediaAbsolutePath.'maxmind')){
                mkdir($mediaAbsolutePath.'maxmind');
            }
            if(!file_exists($maxMindDatabaseDir))
                mkdir($maxMindDatabaseDir);
            
            $client = new \tronovav\GeoIP2Update\Client(array(
                'license_key' => $this->scopeConfig->getValue(ModuleConstant::XML_CONFIG_MAXMIND_PRIVATE_KEY),
                'dir' => $maxMindDatabaseDir,
                'editions' => array("GeoLite2-City"),
            ));
            //echo $this->getMediaAbsolutePath().DIRECTORY_SEPARATOR . 'maxmind/db/';
            $client->run();
        }catch(\Exception $ex){
            echo $ex->getMessage(); exit;
        }
       
    }

    /**
     * @param string $relativePath
     * @return string
     */
    protected function getMediaAbsolutePath($relativePath = ''){
        $mediaAbsolutePath = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        return $mediaAbsolutePath.$relativePath;
    }
    
}
