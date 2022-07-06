<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Parser;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GetPoolBtc implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->getMainers();
        $this->getHashratesHisrory();
    }

    /**
     * Получаем воркеров
     */
    protected function getMainers() {
        try {
            $page = 1;
            do {
                $response = Parser::getMainers($page);
                if(!$response->err_no) {
                    $this->saveMainers($response->data->data);
                    if($response->data->page >= $response->data->page_count) {
                        break;
                    }
                    $page++;
                } else {
                    Log::error($response->err_msg);
                    break;
                }
            } while (true);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            Log::error($e);

            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Сохраняем воркеров
     * @param $mainers
     */
    protected function saveMainers($mainers){
        $date = Carbon::now()->subDay()->format('Y-m-d');

        foreach ($mainers as $mainer) {
            if(!$worker = \App\Models\Worker::where('worker_id', $mainer->worker_id)->first()) {
                $worker =  \App\Models\Worker::create([
                    'worker_id' => $mainer->worker_id,
                    'worker_name' => $mainer->worker_name,
                    'reject' => $mainer->reject_percent,
                    'status' => $mainer->status
                ]);
            }

            /* из истории достаем все
            if(!\App\Models\WorkerHashrate::where('id_worker', $worker->id)->where('date', $date)->count()) {
                \App\Models\WorkerHashrate::create([
                    'id_worker' => $worker->id,
                    'date' => $date,
                    'hashrate' => $mainer->shares_1d
                ]);
            }
            */
        }
    }

    /**
     * Историях Hashrate по майнерам
     */
    protected function getHashratesHisrory($subDays = 14) {
        try {
            $start = Carbon::now()->subDays($subDays)->startOfDay()->getTimestamp();
            foreach (\App\Models\Worker::all() as $worker) {
                $response =  \App\Models\Parser::getHistory($worker->worker_id, $start);
                $result = [];
                foreach ($response->data->tickers as $ticker) {
                    $date = date('Y-m-d', $ticker[0]);
                    $result[$date][] = $ticker[1];
                }

                foreach ($result as $date => $hashrates) {
                    $sum = 0;
                    foreach ($hashrates as $hashrate) {
                        $sum += floatval($hashrate);
                    }
                    $hashrate_avg = round($sum/count($hashrates), 2);

                    if(!$hashrate = \App\Models\WorkerHashrate::where('id_worker', $worker->id)->where('date', $date)->first()) {
                        \App\Models\WorkerHashrate::create([
                            'id_worker' => $worker->id,
                            'date' => $date,
                            'hashrate' => $hashrate_avg
                        ]);
                    } else {
                        $hashrate->update(['hashrate' => $hashrate_avg]);
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            Log::error($e);

            throw new \Exception($e->getMessage());
        }
    }


}
