<?php

namespace App;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache;

class CacheKernel extends HttpCache
{
    public function __construct(Kernel $kernel)
    {
        parent::__construct($kernel);

        $kernel->boot();
        $kernel->getContainer()->set('app.cache_reverse_proxy', $this);
    }
}