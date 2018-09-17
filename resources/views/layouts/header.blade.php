<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta id="csrf_token" name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shipwire') }}</title>

    <!-- Styles -->
    <!-- <link href="{{ asset('semantic/semantic.min.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

@include('layouts.navbar')
