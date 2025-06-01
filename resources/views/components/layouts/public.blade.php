@props(['title' => null, 'description' => null])

@extends('layouts.public')

@section('content')
    {{ $slot }}
@endsection 