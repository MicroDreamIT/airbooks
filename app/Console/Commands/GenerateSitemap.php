<?php

namespace App\Console\Commands;

use App\Http\Controllers\SitemapController;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'running sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $sitemap = new SitemapController();
        $sitemap->aircraft();
        $sitemap->apu();
        $sitemap->engine();
        $sitemap->wanted();
        $sitemap->contact();
        $sitemap->company();
        $sitemap->news();
        $sitemap->airport();
        $sitemap->event();
        $sitemap->staticContent();
    }
}
