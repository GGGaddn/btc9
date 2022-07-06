<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{

    public function index(Request $request) {
        $workers = [];
        $dates = [];
        $sum = 0;
        if($request->post()) {
            $request->validate([
                'date-start' => 'required|date_format:Y-m-d',
                'date-finish' => 'required|date_format:Y-m-d'
            ]);

            $date_start = Carbon::create($request->input('date-start'));
            $date_finish = Carbon::create($request->input('date-finish'));
            $tariff = floatval($request->input('tariff'));
            $consumption = floatval($request->input('consumption'));

            for ($i = $date_start->timestamp ; $i <= $date_finish->timestamp; $i += 86400) {
                $dates[] = date('Y-m-d', $i);
            }

            $hashrates = DB::table('worker_hashrates')
                ->Join('workers', 'worker_hashrates.id_worker', '=', 'workers.id')
                ->where('worker_hashrates.date', '>=', $date_start->format('Y-m-d'))
                ->where('worker_hashrates.date', '<=', $date_finish->format('Y-m-d'))
                ->get();
            foreach($hashrates->unique('worker_id') as $worker) {
                $workers[$worker->worker_id]['worker_name'] = $worker->worker_name;
                $workers[$worker->worker_id]['sum'] = 0;

                for ($i = $date_start->timestamp ; $i <= $date_finish->timestamp; $i += 86400) {
                    if($hashrates->where('id_worker', $worker->id_worker)->where('date', date('Y-m-d', $i))->count()) {
                        $amount = round(($tariff * $consumption * 24 / 13.5) * $hashrates->where('id_worker', $worker->id_worker)->where('date', date('Y-m-d', $i))->first()->hashrate, 2);
                        $workers[$worker->worker_id]['dates'][date('Y-m-d', $i)]['amount'] = $amount;
                        $workers[$worker->worker_id]['dates'][date('Y-m-d', $i)]['hashrate'] = $hashrates->where('id_worker', $worker->id_worker)->where('date', date('Y-m-d', $i))->first()->hashrate;
                        $workers[$worker->worker_id]['sum'] += $amount;
                        $sum += $amount;
                    } else {
                        $workers[$worker->worker_id]['dates'][date('Y-m-d', $i)]['amount'] = 0;
                        $workers[$worker->worker_id]['dates'][date('Y-m-d', $i)]['hashrate'] = 0;
                    }
                }
            }
        }

        return view('index', ['filters' => $request->input(), 'workers' => $workers, 'dates' => $dates, 'sum' => $sum]);
    }

    /**
     * Экспорт в Excel
     * @param Request $request
     */
    public function export(Request $request) {
        $workers = [];
        $headers = ['Воркер', 'Итого'];
        $sum = 0;
        $request->validate([
            'date-start' => 'required|date_format:Y-m-d',
            'date-finish' => 'required|date_format:Y-m-d'
        ]);

        $date_start = Carbon::create($request->input('date-start'));
        $date_finish = Carbon::create($request->input('date-finish'));
        $tariff = floatval($request->input('tariff'));
        $consumption = floatval($request->input('consumption'));

        for ($i = $date_start->timestamp ; $i <= $date_finish->timestamp; $i += 86400) {
            $headers[] = date('Y-m-d', $i).' (Th/s)';
            $headers[] = date('Y-m-d', $i).' (руб.)';
        }

        $hashrates = DB::table('worker_hashrates')
            ->Join('workers', 'worker_hashrates.id_worker', '=', 'workers.id')
            ->where('worker_hashrates.date', '>=', $date_start->format('Y-m-d'))
            ->where('worker_hashrates.date', '<=', $date_finish->format('Y-m-d'))
            ->get();
        foreach($hashrates->unique('worker_id') as $worker) {
            $workers[$worker->worker_id]['worker_name'] = $worker->worker_name;
            $workers[$worker->worker_id]['sum'] = 0;

            for ($i = $date_start->timestamp ; $i <= $date_finish->timestamp; $i += 86400) {
                if($hashrates->where('id_worker', $worker->id_worker)->where('date', date('Y-m-d', $i))->count()) {
                    $amount = round(($tariff * $consumption * 24 / 13.5) * $hashrates->where('id_worker', $worker->id_worker)->where('date', date('Y-m-d', $i))->first()->hashrate, 2);
                    $workers[$worker->worker_id][date('Y-m-d', $i).'-hrt'] = $hashrates->where('id_worker', $worker->id_worker)->where('date', date('Y-m-d', $i))->first()->hashrate;
                    $workers[$worker->worker_id][date('Y-m-d', $i).'-sum'] = $amount;
                    $workers[$worker->worker_id]['sum'] += $amount;
                    $sum += $amount;
                } else {
                    $workers[$worker->worker_id][date('Y-m-d', $i).'-hrt'] = 0;
                    $workers[$worker->worker_id][date('Y-m-d', $i).'-sum'] = 0;
                }
            }
        }

        $export = new \App\Exports\WorkersExport($workers, $headers);

        return  Excel::download($export, 'workers.xlsx');
    }

}
