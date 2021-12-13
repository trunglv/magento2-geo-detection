<?php
namespace Betagento\IPDetection\Router\Job;

use Magento\Framework\App\Request\Http as HttpRequest;

interface JobInterface
{
    public function execute(HttpRequest $resquest) : void;
}
