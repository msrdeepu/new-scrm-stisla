<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <meta name="id" content="">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta name="auth_id" content="{{ auth()->user()->id }}">
    <meta name="url" content="{{ public_path() }}">
    <title>Chatting Application</title>
    <link rel="icon" type="image/png" href="{{ asset('backend/cassets/images/chat_list_icon.png') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/emojionearea.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">

    <link rel="stylesheet" href="{{ asset('backend/cassets/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/responsive.css') }}">

    {{-- notyf js --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/js/messenger.js'])
</head>

<body>

    @yield('content')


    <!--jquery library js-->
    <script src="{{ asset('backend/cassets/js/jquery-3.7.1.min.js') }}"></script>
    <!--bootstrap js-->
    <script src="{{ asset('backend/cassets/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('backend/cassets/js/Font-Awesome.js') }}"></script>
    <script src="{{ asset('backend/cassets/js/slick.min.js') }}"></script>
    <script src="{{ asset('backend/cassets/js/venobox.min.js') }}"></script>
    <script src="{{ asset('backend/cassets/js/emojionearea.min.js') }}"></script>
    {{-- notyf js --}}
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    {{-- progress --}}
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--main/custom js-->
    <script src="{{ asset('backend/cassets/js/main.js') }}"></script>

    <script>
        var notyf = new Notyf({
            duration: 2000,
            position: {
                x: 'right',
                y: 'top',
            },
        });
    </script>

    @stack('scripts')

</body>

</html>
