<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AudioCall;
use App\Models\JobsProcessed;
use Illuminate\Bus\Queueable;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Exceptions\Renderer\Exception;

class ProcessAudioCall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $jobprocess;
    /**
     * Create a new job instance.
     */
     /**
        * Indicate if the job should be marked as failed on timeout.
        *
        * @var bool
        */
        public $failOnTimeout = false;
   
    public function __construct($jobprocess)
    {
    
        $this->jobprocess = $jobprocess;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // exec('envoy run run_pipeline'); 
        //startTime
        $this->jobprocess->starttime = Carbon::now();
        $this->jobprocess->status = Config::get('mappings.statuses.processing');
        $this->jobprocess->save();
        //AudioAnalyticsProcess
        $random_number = rand(200, 500);
        echo "Random number between 200 and 500: $random_number";
        // sleep($random_number);
        //  sleep(10);
        echo "\n";
        $output = shell_exec('php vendor/bin/envoy run python_script');
        echo $output;
        //endTime
        $this->jobprocess->endtime = Carbon::now();
        $this->jobprocess->duration =($this->jobprocess->endtime)->diffInSeconds($this->jobprocess->starttime);
        $this->jobprocess->status = Config::get('mappings.statuses.completed');
        $this->jobprocess->save(); 
        // sleep(10);    
        

    }
    public function failed(\Throwable $exception)
    {    
        
        $failque = JobsProcessed::where('audiocall_id', $this->jobprocess->audiocall_id)->first();
        if ($failque) {

            $failque->retries += 1;

            if ($failque->retries >= 3) {
                // Set endtime and calculate duration
                $failque->endtime = Carbon::now();
                $failque->duration = $failque->endtime->diffInSeconds($this->jobprocess->starttime);
            }
            $failque->status =  $this->jobprocess->status = Config::get('mappings.statuses.failed');
            $failque->save();
            if ($failque->retries < 3) {
                ProcessAudioCall::dispatch($this->jobprocess);
            }
        } 
          
    }
       
}


