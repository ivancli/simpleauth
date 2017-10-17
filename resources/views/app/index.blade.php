@extends('layouts.angle')

@section('title', 'OzSpy')

@section('links')
    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
@stop

@section('head_scripts')
    {{--<script src='https://www.google.com/recaptcha/api.js'></script>--}}
@stop

@section('body')
    <div id="ozspy" class="wrapper" v-cloak>
        <angle-header></angle-header>
        <angle-sidebar></angle-sidebar>
        <angle-content>
            <index slot="page-content"></index>
        </angle-content>
    </div>
@stop

@section('body_scripts')
    <script src="{{mix('/js/app.js')}}"></script>
@stop