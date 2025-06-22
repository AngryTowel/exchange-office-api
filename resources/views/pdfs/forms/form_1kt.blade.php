<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <title>1КТ Формулар</title>
    <link rel="stylesheet" href="{{ resource_path('css/forms_pdf.css') }}">
</head>
<body>
<div class="container">
    <div class="header">Образец за книжење на трансакциите на ден {{ \Carbon\Carbon::createFromDate($form_data->date_time)->format('d-m-Y') }} бр. 1КТ</div>
    <table class="table layout-fixed">
        <tr>
            <td colspan="3">Матичен број на овластениот менувач: <br><br> <p class="text-center">{{ $form_data->organization->exchange_id }}</p></td>
            <td colspan="3">Име на овластениот менувач: <br><br> <p class="text-center">{{ $form_data->organization->name }}</p></td>
            <td colspan="4">Адреса на менувачко место: <br><br> <p class="text-center">{{ $form_data->organization->address }}</p></td>
        </tr>
        <tr>
            <td colspan="10">
                Име на овластената банка: {{ $form_data->authorized_bank }} <br>
            </td>
        </tr>
        <tr>
            <td class="text-center">Ред бр.</td>
            <td class="text-center">Број на документот</td>
            <td class="text-center">Опис</td>
            <td colspan="7" class="p-0">
                <table class="table layout-fixed">
                    <tr>
                        <td class="text-center inner-cell border-t-0" colspan="5">Ефективни странски пари и чекови</td>
                        <td class="text-center inner-cell border-t-0" colspan="2">Износ во денари</td>
                    </tr>
                    <tr>
                        <td class="text-center inner-cell">Вид на валута</td>
                        <td class="text-center inner-cell">Курс</td>
                        <td class="text-center inner-cell">Вид на средства</td>
                        <td class="text-center inner-cell">Влез</td>
                        <td class="text-center inner-cell">Излез</td>
                        <td class="text-center inner-cell">Влез</td>
                        <td class="text-center inner-cell">Излез</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td class="text-center">2</td>
            <td class="text-center">3</td>
            <td class="text-center">4</td>
            <td class="text-center">5</td>
            <td class="text-center">6</td>
            <td class="text-center">7</td>
            <td class="text-center">8</td>
            <td class="text-center">9</td>
            <td class="text-center">10</td>
        </tr>
        <tr>
            <td class="text-center">{{ $form_data->custom_id }}</td>
            <td class="text-center">{{ $form_data->document_no }}</td>
            <td class="text-center">{{ $form_data->description }}</td>
            <td class="text-center">{{ $form_data->currency_type }}</td>
            <td class="text-center">{{ $form_data->rate }}</td>
            <td class="text-center">{{ $form_data->funds_type }}</td>
            <td class="text-center">{{ $form_data->exchange_amount_input }}</td>
            <td class="text-center">{{ $form_data->exchange_amount_output }}</td>
            <td class="text-center">{{ $form_data->value_input }}</td>
            <td class="text-center">{{ $form_data->value_output }}</td>
        </tr>
        <tr>
            <td colspan="10">Име презиме и потпис на овластеното лице: <br></td>
        </tr>
        <tr>
            <td colspan="10">Име презиме и потпис на одговорното лице или на друго лице овластено од одговорното лице: <br> {{ $form_data->organization->owner->first_name }} {{ $form_data->organization->owner->last_name }}</td>
        </tr>
    </table>
</div>
</body>
</html>
