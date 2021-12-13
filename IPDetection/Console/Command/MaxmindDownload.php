<?php

namespace Betagento\IPDetection\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\ObjectManager;

use Betagento\IPDetection\Model\Maxmind\Download as MaxmindDownloadProcess;


class MaxmindDownload extends Command
{
    /**
     * MaxmindDownloadProcess
     * @var MaxmindDownloadProcess
     */
    protected $downloadProcess;

    /**
     * @param MaxmindDownloadProcess $downloadProcess
     */
    public function __construct(
        MaxmindDownloadProcess $downloadProcess

    ) {
        $this->downloadProcess = $downloadProcess;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('betagento:geoip_detection:maxmind_download');
        $this->setDescription('Maxmind Download Solution');
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
        $this->downloadProcess->execute();
        return NULL;
    }
}
