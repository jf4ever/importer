@extends('layouts.app')

@section('title', 'Список товаров')

@section('content')
{{ $data->id }}<br>
{{ $data->name }}<br>
{{ $data->price }}<br>
{{ $data->description }}<br>
<a href="{{ $data->url }}">{{ $data->url }}</a><br>
@if ($data->picture)
    <img src="{{ $data->picture }}" /><br>
@endif
@endsection
