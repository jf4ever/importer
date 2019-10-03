@extends('layouts.app')
@section('title', 'Результаты импорта')
@section('content')
    <style>
        .result_set > div{
            border-top: #c4c4c4 1px solid;
        }
        .result_set > div:first-child{
            border-top: none;
        }
    </style>
    <p>
        <div class="result_set">
            @foreach ($result as $url => $res)
                <div>
                    <h2>{{ $url }}</h2>
                    <div>
                        @if ($res['success'] === 'OK')
                            <b style="color: green; font-size: 20px;">Успех</b>
                            <br>
                        @else
                            <b style="color: red; font-size: 20px;">Ошибка</b>
                            <br>
                            {{ $res['message'] }}
                        @endif
                        <div>
                            Добавлено: {{ $res['added'] }} / Изменено: {{ $res['updated'] }} / Без изменений: {{ $res['missed'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </p>
@endsection
