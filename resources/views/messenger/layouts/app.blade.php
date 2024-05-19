<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <title>Chatting Application</title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/emojionearea.min.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/cassets/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cassets/css/responsive.css') }}">
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

    <!--main/custom js-->
    <script src="{{ asset('backend/cassets/js/main.js') }}"></script>

</body>

</html>
