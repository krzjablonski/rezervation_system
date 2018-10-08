<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Rezerwacja | @yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700,900&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{URL::asset('css/styles.css')}}">

    @yield('styles')
  </head>
  <body>
    @include('partials._admin_nav')
    <div class="container main-container">
