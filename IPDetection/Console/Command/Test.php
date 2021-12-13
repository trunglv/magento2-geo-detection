<?php

namespace Betagento\IPDetection\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\ObjectManager;
use Betagento\IPDetection\Api\GeolocationServiceInterface;

class Test extends Command
{

    const IP_PARAM_NAME = 'ip';

    /**
     * @var GeolocationServiceInterface
     */
    protected $geolocationService;

    /**
     * @param GeolocationServiceInterface $geolocationService
     */
    public function __construct(
        GeolocationServiceInterface $geolocationService

    ) {
        $this->geolocationService = $geolocationService;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('betagento:ipdetection:test');
        $this->setDescription('Maxmind Download Solution');

        $this->addOption(
            self::IP_PARAM_NAME,
            null,
            InputOption::VALUE_REQUIRED,
            'Name'
        );

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $state = ObjectManager::getInstance()->get("Magento\Framework\App\State");
        $state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
        if ($ipAddress = $input->getOption(self::IP_PARAM_NAME)) {
            $executionStartTime = microtime(true);
            $geoInfo = $this->geolocationService->getGeoInfo($ipAddress);
            $executionEndTime = microtime(true);
            $seconds = $executionEndTime - $executionStartTime;
            //Print it out
            $hours = floor($seconds / 3600);
            $mins = floor($seconds / 60 % 60);
            $secs = floor($seconds % 60);
            $timeFormat = sprintf('%02d:%02d:%02d (%s)', $hours, $mins, $secs, $seconds);
            echo "This script took $timeFormat to execute." . PHP_EOL;
            print_r($geoInfo);
           
        }
        return NULL;
    }
}
