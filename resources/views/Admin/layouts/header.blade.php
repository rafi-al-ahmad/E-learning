

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-control" content="public">
    <title>{{ !empty($title) ? $title : (isset(settings()->appName) ? settings()->appName : trans('admin.site-title')) }}</title>

    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
    <!-- Font: Open Sans  -->

    <link rel="stylesheet" href="{{ url('') }}/css/fonts/sans serif/Open Sans/specimen_files/specimen_stylesheet.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="{{ url('') }}/css/fonts/sans serif/Open Sans/stylesheet.css" type="text/css" charset="utf-8" />

    <!-- <link rel="preconnect" href="https://fonts.gstatic.com"> -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500;700;800&display=swap" rel="stylesheet">

    <link rel="icon" href="{{ isset(settings()->favicon) ? Storage::url(settings()->favicon) :'' }}">

    @if(strtolower(langDirection()) == 'rtl')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/design/AdminLTE/RTL') }}/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <!-- <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> -->
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="{{ url('/design/AdminLTE/RTL') }}/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="{{ url('/design/AdminLTE/RTL') }}/dist/css/custom.css">
    @else
    <!-- Theme style -->
    <link rel="stylesheet"  type="text/css"  href="{{ url('/design/AdminLTE') }}/dist/css/adminlte.min.css?v=1235156131">
    @endif
    <style type="text/css">
        body {
            font-family: 'open_sansregular', 'Tajawal', sans-serif;
        }
    </style>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ url('/design/AdminLTE') }}/plugins/fontawesome-free/css/all.min.css">


    <!-- IonIcons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <style>
        #message {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 99999;
        }

        #inner-message {
            margin: 0 auto;
        }
    </style>
    @stack('style')
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body id="body" class="size14 hold-transition sidebar-mini">

    <!-- include('Admin.Announcement.announcement-view') -->
    <div class="wrapper">
