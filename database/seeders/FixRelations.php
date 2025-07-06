<?php

namespace Database\Seeders;

use App\Models\Currencies;
use App\Models\Form1KT;
use App\Models\FormMT1;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FixRelations extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mts = FormMT1::all();

        foreach ($mts as $mt) {
            $c = Currencies::where('currency', $mt->currency_type)->where('organization_id', $mt->organization_id)->first();
            $mt->currency_id = $c->id;

            $mt->save();

            $kt = Form1KT::where('document_no', $mt->custom_id)->where('date_time', $mt->date_time)->first();
            $kt->currency_id = $c->id;
            $kt->form_mt1_id = $mt->id;

            $kt->save();
        }
    }
}
