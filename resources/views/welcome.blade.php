<!doctype html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns#">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:url" content="{{ url()->current() }}">


    @yield('title_meta')

    <link rel="canonical" href="{{ url()->full() }}">
    <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.ico') }}" />

    @vite('resources/js/app.js')

    @yield('css')
</head>

<body data-operation-result="{{ session('operation_result') }}">
    <div id="app">
    
        <main>
            <article>
                <div class="uk-container uk-container-large">
                        @yield('main')
   
                </div>
            </article>

        </main>

        <footer id="footer">
            <div class="uk-section uk-section-xsmall">
                <div class="uk-text-center" style="border-top: solid 4px #fda500;">
                   
                </div>
            </div>
        </footer>
    </div>

    @yield('js')

</body>

</html>
