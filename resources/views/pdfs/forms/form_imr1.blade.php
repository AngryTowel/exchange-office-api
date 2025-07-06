<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <title>ИМР1 Формулар</title>
    <link rel="stylesheet" href="{{ resource_path('css/forms_pdf.css') }}">
</head>
<body>
<div class="container">
    <div class="header text-center">Образец ИМР1 - Извештај за прометот остварен од менувачко работење за периодот од до, во оригинална валута</div>
    <table class="table layout-fixed">
        <tr>
            <td colspan="1"></td>
            <td colspan="7">Матичен број на овластениот менувач: <br><br> <p class="text-center">{{ $organization->exchange_id }}</p></td>
            <td colspan="7">Име на овластениот менувач: {{$organization->name}} <br><br> <p class="text-center">Тел бр.</p></td>
        </tr>
        <tr>
            <td colspan="1"><p class="text-center">Валута</p></td>
            <td colspan="1"><p class="text-center">Почетна состојба</p></td>
            <td colspan="2" class="p-0" style="position: relative">
                <table class="table layout-fixed" style="height: max-content">
                    <tr>
                        <td colspan="2" class="text-center border-t-0 border-l-0 border-r-0">Купени <br><br></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center border-l-0 border-r-0">Купена странска ефектива <br><br></td>
                    </tr>
                    <tr>
                        <td class="text-center border-l-0 border-b-0">Резиден&shy;ти</td>
                        <td class="text-center border-r-0 border-b-0">Нерезиде&shy;нти</td>
                    </tr>
                </table>
            </td>
            <td colspan="1"><p class="text-center">Kупена странска ефектива во евра од овласте&shy;ни бан&shy;ки</p></td>
            <td colspan="1"><p class="text-center">Купени странски чекови</p></td>
            <td colspan="1"><p class="text-center">Куповен курс</p></td>
            <td colspan="1"><p class="text-center">Примања во денари</p></td>
            <td colspan="2" class="p-0" style="position: relative">
                <table class="table layout-fixed" style="height: max-content">
                    <tr>
                        <td colspan="2" class="text-center border-t-0 border-l-0 border-r-0">Продаде&shy;ни <br><br></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center border-l-0 border-r-0">Продаде&shy;на странс&shy;ка ефекти&shy;ва <br><br></td>
                    </tr>
                    <tr>
                        <td class="text-center border-l-0 border-b-0">Резиден&shy;ти</td>
                        <td class="text-center border-r-0 border-b-0">Нерезиде&shy;нти</td>
                    </tr>
                </table>
            </td>
            <td colspan="1"><p class="text-center">Продаде&shy;на странс&shy;ка ефекти&shy;ва на овласте&shy;ни бан&shy;ки</p></td>
            <td colspan="1"><p class="text-center">Предаде&shy;ни странс&shy;ки чеко&shy;ви на овласте&shy;ни бан&shy;ки</p></td>
            <td colspan="1"><p class="text-center">Продаж&shy;ен курс</p></td>
            <td colspan="1"><p class="text-center">Издавања во денари</p></td>
            <td colspan="1"><p class="text-center">Крајна состојба</p></td>
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
            <td class="text-center">11</td>
            <td class="text-center">12</td>
            <td class="text-center">13</td>
            <td class="text-center">14</td>
            <td class="text-center">15</td>
        </tr>
        @foreach($currencies as $currency)
            <tr>
                <td class="text-center">{{ $currency->currency }}</td>
                <td class="text-center">{{ $currency->valueHistories?->first()->initial_value }}</td>
                <td class="text-center">{{ $currency->total_input_residents }}</td>
                <td class="text-center">{{ $currency->total_input_non_residents }}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">{{ number_format($currency->average_buy_rate, 2) }}</td>
                <td class="text-center">@if($currency->isDefault){{ $currency->valueHistories?->sum('input') }} @endif</td>
                <td class="text-center">{{ $currency->total_output_residents }}</td>
                <td class="text-center">{{ $currency->total_output_non_residents }}</td>
                <td class="text-center">{{ $currency->total_output_banks }}</td>
                <td class="text-center"></td>
                <td class="text-center">{{ number_format($currency->average_sell_rate, 2) }}</td>
                <td class="text-center">@if($currency->isDefault){{ $currency->valueHistories?->sum('output') }} @endif</td>
                <td class="text-center">{{ $currency->valueHistories?->last()->value }}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td colspan="14">Потпис на овластеното лице: {{$organization->owner->first_name}} {{$organization->owner->last_name}} <br><br></td>
        </tr>
    </table>
</div>
</body>
</html>
