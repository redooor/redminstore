@extends('redminstore::layouts.master')

@section('head')
<title>Redminstore: {{ $post->title }}</title>
@stop

@section('content')
    {!! $post->content !!}
@stop
