<?php

namespace App\Jobs\Sendgrid;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\SendgridList;
use App\Services\Sendgrid\Commands\Lists\GetAllListsCommand;

class CarryListsIntoDatabase implements ShouldQueue
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
        $command = new GetAllListsCommand();
        $result = $command->execute();

        if ($result['status'] === 200) {
            $lists = $result['payload']->result;
            foreach($lists as $list) {
                SendgridList::create([
                    'id' => $list->id,
                    'name' => $list->name
                ]);
            }
        }
    }
}
