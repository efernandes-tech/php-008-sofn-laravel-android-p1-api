<?php
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * @var string
     */
    protected $proxies = '*';
    /**
     * @var mixed
     */
    protected $headers = Request::HEADER_X_FORWARDED_AWS_ELB;
}
