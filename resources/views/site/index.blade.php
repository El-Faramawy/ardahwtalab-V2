<html>

<head>
    @include('site.layout.assets')
</head>

<body>

    @include('site.layout.header')
        @hasSection('page')
            <div class="pageCont">
                <div class="row">
                @yield('page')
                </div>
            </div>
        @hasSection ('custom_page')
            @yield('custom_page')
        @endif
    @include('site.layout.footer')

    @endif
</body>

</html>
