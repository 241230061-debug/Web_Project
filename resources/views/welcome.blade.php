@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
 
    @include('partials.hero')

    @include('partials.services')

    @include('partials.ai-matcher')

@endsection
