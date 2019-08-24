<?php

namespace App\Http\Controllers;

use App\Aircraft;
use App\Airport;
use App\Apu;
use App\Company;
use App\Contact;
use App\Engine;
use App\Event;
use App\Http\GlobalMethods;
use App\News;
use App\Wanted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    /**
     * This file is a part of MicroDreamIT
     * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
     *
     * For the full copyright and license information, please view the LICENSE
     * or visit https://microdreamit.com
     * @var Sitemap
     */
//    public $sitemap;
//    public $minute;
//
//    public function __construct(Sitemap $sitemap)
//    {
//        (new sitemap()) = $sitemap;
//        $this->minute = 24 * 60;
//    }

    public function aircraft()
    {
        $sitemap = new Sitemap();
        Aircraft::where('isActiveStatus', 'Approved')->where('is_active_by_user', 1)->get()->each(function (Aircraft $aircraft) use ($sitemap) {
            $title = Url::create((new GlobalMethods())->assetUrlGenerator($aircraft));
            $sitemap->add($title);
//            (new sitemap())->add($title);
        });

        $sitemap->writeToFile(public_path('sitemap/aircraft-sitemap.xml'));


    }

    public function apu()
    {
        $sitemap= new Sitemap();
        Apu::where('isActiveStatus', 'Approved')->where('is_active_by_user', 1)->get()->each(function (Apu $apu) use ($sitemap) {
            $title = Url::create((new GlobalMethods())->assetUrlGenerator($apu));
            $sitemap->add($title);
        });

        $sitemap->writeToFile(public_path('sitemap/apu-sitemap.xml'));



    }

    public function engine()
    {
        $sitemap = new Sitemap();
        Engine::where('isActiveStatus', 'Approved')->where('is_active_by_user', 1)->get()->each(function (Engine $engine) use ($sitemap) {
            $title = Url::create((new GlobalMethods())->assetUrlGenerator($engine));
            $sitemap->add($title);
        });

        $sitemap->writeToFile(public_path('sitemap/engine-sitemap.xml'));

    }

    public function wanted()
    {
        $sitemap = new Sitemap();
        Wanted::where('is_active', 1)->get()->each(function (Wanted $wanted) use ($sitemap) {
            $title = Url::create((new GlobalMethods())->assetUrlGenerator($wanted));
            $sitemap->add($title);
        });

        $sitemap->writeToFile(public_path('sitemap/wanted-sitemap.xml'));


    }

    public function contact()
    {
        $sitemap = new Sitemap();
        Contact::where('is_published', 1)->whereNotNull('user_id')->each(function (Contact $contact) use ($sitemap) {
            $title = Url::create($contact['linkify']);
            $title = 'contact/'.$title->url;
            $sitemap->add($title);
        });

        $sitemap->writeToFile(public_path('sitemap/contact-sitemap.xml'));

    }

    public function company()
    {
        $sitemap = new Sitemap();
        Company::where('is_active', 1)->get()->each(function (Company $company) use ($sitemap) {
            $title = Url::create($company['linkify']);
            $title = 'company/'.$title->url;
            $sitemap->add($title);
        });

        $sitemap->writeToFile(public_path('sitemap/company-sitemap.xml'));


    }

    public function news()
    {
                $sitemap = new Sitemap();

        News::where('is_active', 1)->get()->each(function (News $news) use ($sitemap) {
            $title = Url::create($news['linkify']);
            $title = 'news/'.$title->url;
            $sitemap->add($title);
        });

        $sitemap->writeToFile(public_path('sitemap/news-sitemap.xml'));

    }

    public function airport()
    {
                $sitemap = new Sitemap();

        Airport::where('is_active', 1)->get()->each(function (Airport $airport) use ($sitemap) {
            $title = Url::create($airport['linkify']);
            $title = 'airport/'.$title->url;
            $sitemap->add($title);
        });

        $sitemap->writeToFile(public_path('sitemap/airport-sitemap.xml'));

    }

    public function event()
    {
                $sitemap = new Sitemap();

        Event::where('is_active', 1)->get()->each(function (Event $event) use ($sitemap) {
            $title = Url::create($event['linkify']);
            $title = 'event/'.$title->url;
            $sitemap->add($title);
        });

        $sitemap->writeToFile(public_path('sitemap/event-sitemap.xml'));
    }

    public function staticContent()
    {
                $sitemap = new Sitemap();

        $sitemap
            ->add('/about-airbook')
        ->add('/airbook-features')
        ->add('/support')
        ->add('/')
        ->add('/aircraft')
        ->add('/engine')
        ->add('/apu')
        ->add('parts')
        ->add('/wanted')
        ->add('/news')
        ->add('/event')
        ->add('/contact')
        ->add('/company')
        ->add('/airport');

        $sitemap->writeToFile(public_path('sitemap/static-sitemap.xml'));


    }
}
