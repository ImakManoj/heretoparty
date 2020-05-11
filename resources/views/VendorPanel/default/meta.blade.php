<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dashboard">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

       <title>@yield('title')</title>
 <!-- Favicon -->

  <link rel="shortcut icon" href="favicon.png" sizes="64x64" type="image/x-icon">  <!-- CSS -->

  <link rel="stylesheet" href="{{asset('heretoparty/dashboard')}}/css/dashboard.css">

  <link rel="stylesheet" href="{{asset('heretoparty')}}/css/custom.css"> 


 
</head>
<body class="dashboard user-dashboard">
 
       <div id="app">