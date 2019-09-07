<meta charset="utf-8">

<title id="title">{{isset($metaHead)? $metaHead->title : \App\Seo::where('method', 'Home')->first()->title }}</title>
<meta name="description" content="{{isset($metaHead) ? \App\Http\GlobalMethods::seo_description($metaHead->description, 0,165) : \App\Http\GlobalMethods::seo_description(substr(\App\Seo::where('method', 'Home')->first()->description, 0,165)) }}">
<meta name="image" content="{{isset($metaHead) && key_exists('medias',$metaHead) && $metaHead->medias[0] ? $metaHead->medias[0] : 'https://airbook.aero/storage/Seo/abhomeart.jpg'}}">

<meta content="width=device-width, initial-scale=1" name="viewport">

<meta name="yandex-verification" content="e1e300b5ee6e4d3c" />

<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="fragment" content="!">
