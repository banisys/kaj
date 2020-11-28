<?php

namespace App\Console\Commands;


use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use App\Services\MessagingService;

class SendCartNotificatoins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:carts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Notifies unpaid carts every 15 minutes.";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       try {
            // $file_path = $this->argument('path');

            // $duration = system(env('FFMPEG_PATH', '/usr/bin') . "/ffmpeg -i " . $root . $file_path . " 2>&1 | grep Duration | awk '{print $2}' | tr -d , |  awk '{gsub(/\.[0-9]*/,\"\",$1)}1'");
            // $command = env('FFMPEG_PATH', '/usr/bin') . "/ffprobe -i " . $file_path . ' -show_entries format=duration -v quiet -of csv="p=0" 2>&1';

            // ob_start();

            // $duration = shell_exec($command);

            // ob_end_clean();

            MessagingService::sendCartMessages();

            // $this->comment($duration_in_seconds);

            return 0;
        } catch (Exception $th) {
            return 1;
        }
    }
}
