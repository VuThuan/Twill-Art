<?php

namespace App\Console\Commands;

use A17\Twill\Services\Cache\CloudfrontCacheService;
use Illuminate\Console\Command;

class InvalidateCloudfront extends Command
{
    protected $signature = 'cache:invalidate-cloudfront {urls?*}';

    protected $description = 'Invalidate cloudfront distribution.';

    public function handle()
    {
        if (config('services.cloudfront.enabled')) {
            if (!empty($this->argument('urls'))) {
                app(CloudfrontCacheService::class)->invalidate($this->argument('urls'));
            }

            $this->info('Cloudfront invalidation request sent!');
        }
    }
}
