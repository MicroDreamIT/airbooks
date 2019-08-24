<?php

namespace App\Console\Commands;

use App\Aircraft;
use App\Apu;
use App\Engine;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class featureStatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feature:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Featured Status updated related';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $aircrafts = Aircraft::with('user')->where('is_featured')->get();
        foreach ($aircrafts as $aircraft ){
            $trans_date = $aircraft->user->trans_date;
            $p_code = $aircraft->user->order_id;
            $p_date = $aircraft->promotion_date;

            if($p_code == 101 || $p_code == 201){
                $days=Carbon::parse($trans_date)->diffInDays(Carbon::now());
                if($days>31){
                    $aircraft->update([
                        'is_featured'=>false
                    ]);
                }
            }elseif ($p_code == 102 || $p_code== 202){
                $days=Carbon::parse($trans_date)->diffInDays(Carbon::now());
                if($days>365){
                    $aircraft->update([
                        'is_featured'=>false
                    ]);
                }
            }
        }

        $engines = Engine::with('user')->where('is_featured')->get();
        foreach ($engines as $engine ){
            $trans_date = $engine->user->trans_date;
            $p_code = $engine->user->order_id;
            $p_date = $engine->promotion_date;

            if($p_code == 101 || $p_code == 201){
                $days=Carbon::parse($trans_date)->diffInDays(Carbon::now());
                if($days>31){
                    $engine->update([
                        'is_featured'=>false
                    ]);
                }
            }elseif ($p_code == 102 || $p_code== 202){
                $days=Carbon::parse($trans_date)->diffInDays(Carbon::now());
                if($days>365){
                    $engine->update([
                        'is_featured'=>false
                    ]);
                }
            }
        }


        $apus = Apu::with('user')->where('is_featured')->get();
        foreach ($apus as $apu ){
            $trans_date = $apu->user->trans_date;
            $p_code = $apu->user->order_id;
            $p_date = $apu->promotion_date;

            if($p_code == 101 || $p_code == 201){
                $days=Carbon::parse($trans_date)->diffInDays(Carbon::now());
                if($days>31){
                    $apu->update([
                        'is_featured'=>false
                    ]);
                }
            }elseif ($p_code == 102 || $p_code== 202){
                $days=Carbon::parse($trans_date)->diffInDays(Carbon::now());
                if($days>365){
                    $apu->update([
                        'is_featured'=>false
                    ]);
                }
            }
        }





    }
}
