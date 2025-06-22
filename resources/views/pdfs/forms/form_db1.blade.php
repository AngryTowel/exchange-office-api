<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <title>1ДБ Формулар</title>
    <link rel="stylesheet" href="{{ resource_path('css/forms_pdf.css') }}">
</head>
<body>
<div class="container">
    <div class="header">Образец за пресметка на дневната благајна на ден {{ $date }} бр. 1ДБ</div>
    <table class="table layout-fixed">
        <tr>
            <td>Матичен број на овластениот менувач: {{ $organization->exchange_id }}</td>
            <td>Име на овластениот менувач: {{ $organization->name }}</td>
            <td>Адреса на овластениот менувач: {{ $organization->address }}</td>
        </tr>
    </table>
    <table class="table layout-fixed">
        <tr>
            <td>Вид на валута</td>
            <td>Почетна состојба</td>
            <td>Влез</td>
            <td>Излез</td>
            <td>Крајна состојба</td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td class="text-center">2</td>
            <td class="text-center">3</td>
            <td class="text-center">4</td>
            <td class="text-center">5</td>
        </tr>
        @foreach($histories as $history)
            <tr>
                <td>{{ $history->currency->currency }}</td>
                <td>{{ $history->initial_value }}</td>
                <td>{{ $history->input }}</td>
                <td>{{ $history->output }}</td>
                <td>{{ $history->value }}</td>
            </tr>
        @endforeach
    </table>
    <table class="table layout-fixed">
        <tr>
            <td>Име презиме и потпис на овластеното лице: </td>
            <td>
                Име презиме и потпис на одговорното лице или на друго лице овластено од одговорното лице: <br><br>
                {{ $organization->owner->first_name }} {{ $organization->owner->last_name }}
            </td>
        </tr>
    </table>
</div>
</body>
</html>
