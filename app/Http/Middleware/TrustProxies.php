<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Closure;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array|string|null
     */
    protected $proxies = [];

    /**
     * The proxy header mappings.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_AWS_ELB;

    /**
     * Add remote address to trusted proxy list
     *
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle(Request $request, Closure $next)
    {
        $ips = Cache::remember('list-cloudfront-ips', 60 * 60, function () {
            if (Storage::exists('list-cloudfront-ips.json')) {
                return Storage::get('list-cloudfront-ips.json');
            }

            return '{"CLOUDFRONT_GLOBAL_IP_LIST": [], "CLOUDFRONT_REGIONAL_EDGE_IP_LIST": []}';
        });

        $ips = json_decode($ips);

        $this->proxies = array_merge(
            $this->proxies,
            $ips->{'CLOUDFRONT_GLOBAL_IP_LIST'},
            $ips->{'CLOUDFRONT_REGIONAL_EDGE_IP_LIST'}
        );

        array_push($this->proxies, $request->server->get('REMOTE_ADDR'));

        return parent::handle($request, $next);
    }
}
