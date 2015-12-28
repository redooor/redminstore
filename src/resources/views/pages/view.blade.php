@extends('redminstore::layouts.master')

@section('head')
<title>Redminstore: {{ $page->title }}</title>
@stop

@section('content')
    {!! $page->content !!}
@stop
