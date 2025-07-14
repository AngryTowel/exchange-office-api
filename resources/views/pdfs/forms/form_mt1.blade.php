<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <title>МТ1 Формулар</title>
    <link rel="stylesheet" href="{{ resource_path('css/forms_pdf.css') }}">
</head>
<body>
<div class="container">
    <div class="header">Потврда за купување/продавање ефективни странски пари и чекови</div>
    <div class="sub-header">Образец МТ1</div>
    <table class="table layout-fixed">
        <tr>
            <td colspan="4">Овластен менувач: {{ $form_data->organization->name }} <br><br><br> Овластена банка: {{ $form_data->аuthorized_bank }}</td>
            <td colspan="2">Број на потврдата <br><br> <p class="text-center">{{ $form_data->custom_id }}</p></td>
            <td colspan="2">Датум и време <br><br> <p class="text-center">{{ \Carbon\Carbon::createFromDate($form_data->date_time)->format('d-m-Y H:i') }}</p></td>
            <td>Купувам <br><br> @if($form_data->type == 1) <p class="text-center">{{ $form_data->type }}</p> @endif</td>
            <td class="pl-0">Продавам <br><br> @if($form_data->type == 2) <p class="text-center">{{ $form_data->type }}</p> @endif</td>
        </tr>
    </table>
    <table class="table layout-fixed">
        <tr>
            <td>Вид на валутата: <br><br> <p class="text-center">{{ $form_data->currency_type }}</p></td>
            <td colspan="2">Износ на ефективни странски пари и чекови <br><br> <p class="text-center">{{ $form_data->exchange_amount }}</p></td>
            <td>Курс <br><br> <p class="text-center">{{ $form_data->rate }}</p></td>
            <td>Износ во денари <br><br> <p class="text-center">{{ $form_data->value }}</p> </td>
        </tr>
    </table>
    <table class="table layout-fixed">
        <tr>
            <td colspan="2">Резидент/нерезидент <br><br> <p class="text-center">{{ $form_data->residency }}</p></td>
            <td colspan="2">Документ за идентификација: <br><br> <p class="text-center">{{ $form_data->exchange_id }}</p></td>
            <td>Овластено лице <br><br> <p class="text-center">{{ $form_data->organization->owner->first_name }} {{ $form_data->organization->owner->last_name }}</p> </td>
        </tr>
    </table>
</div>
</body>
</html>
