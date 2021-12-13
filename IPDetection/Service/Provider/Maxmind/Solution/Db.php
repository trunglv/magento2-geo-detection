<?php 
namespace Betagento\IPDetection\Service\Provider\Maxmind\Solution;

use GeoIp2\Database\Reader;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Betagento\IPDetection\Model\Constant;
use Betagento\IPDetection\Service\Provider\Maxmind\Solution\SolutionInterface;

class Db implements SolutionInterface{

    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @param Filesystem $fileSystem
     */
    public function __construct(
        Filesystem $fileSystem
    )
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * @param string $ipAddress
     * @return array<string,string>
     */
    public function execute($ipAddress){
        $mediaAbsolutePath = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        try{
            $reader = new Reader($mediaAbsolutePath.Constant::MAXMIND_CITY_DATABASE_FILE_PATH);
            $record = $reader->city($ipAddress);
            return [
                'country_code' => $record->country->isoCode,
                'zip_code' => $record->postal->code,
                'city_name' => $record->city->name
            ];
        }catch(\Exception $ex){

        }
        return [];
    }
}