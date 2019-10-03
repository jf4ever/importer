@extends('layouts.app')
@section('title', 'Запуск импорта')
@section('content')
    <p>
    <form action="{{ route('importStart') }}" method="post">
        @csrf
        <button type="submit">Запустить импорт</button>
    </form>
    </p>
@endsection
