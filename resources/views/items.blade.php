@extends('layouts.app')

@section('title', 'Список товаров')

@section('content')
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#autocompleteFrom").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "{{ route('s_autocomplete') }}",
                        data: { term: request.term },
                        success: function (data) {
                            var transformed = $.map(data, function (el) {
                                return {
                                    label: el.name,
                                    id: el.id
                                };
                            });
                            response(transformed);
                        },
                        error: function () {
                            response([]);
                        }
                    });
                },
                minLength: 2,
                select: function (event, ui) {
                    window.location.href = "/items/" + ui.item.id;
                }
            });
        });
    </script>
    <div class="ui-widget">
        <label for="Countries">Поиск: </label>
        <input id="autocompleteFrom">
    </div>
    <div class="item_list">
        @foreach ($data as $row)
            <div class="item_list_row">
                <div>{{ $row['id'] }}</div>
                <div><a href="/items/{{ $row['id'] }}">{{ $row['name'] }}</a></div>
                <div>{{ $row['price'] }}</div>
                <div>{{ $row['currency'] }}</div>
            </div>
        @endforeach
    </div>
@endsection
