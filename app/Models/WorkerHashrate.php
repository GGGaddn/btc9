<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerHashrate extends Model
{
    use HasFactory;

    protected $table = 'worker_hashrates';

    protected $fillable = [
        'id_worker', 'date', 'hashrate'
    ];

}
