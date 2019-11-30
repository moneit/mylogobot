<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Sendgrid\Commands\Lists\GetAllListsCommand;
use App\Services\Sendgrid\Commands\Contacts\GetAllContactsCommand;
use App\Services\Sendgrid\Commands\Contacts\SearchContactByEmailCommand;
use App\Services\Sendgrid\Commands\Contacts\AddUpdateContactsCommand;
use App\Services\Sendgrid\Commands\Lists\CreateListCommand;
use App\Jobs\Sendgrid\CarryListsIntoDatabase;
use App\Jobs\Sendgrid\CreateUserContactInNotBuyersList;
use App\Jobs\Sendgrid\MoveUserContactFomNotBuyersListToBuyersList;

class SendgridAllListsTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:sendgrid-all-lists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        \Log::error('send grid key', [env('SENDGRID_API_KEY')]);
//        $command = new SearchContactByEmailCommand('kitdb1122@gmail.com');
        $command = new GetAllListsCommand();
        $res = $command->execute();
        \Log::error('command result', [$res]);

//        dispatch(new CarryListsIntoDatabase());

//        $user = \App\User::where('email', 'kitdb1122@gmail.com')->first();
//        dispatch(new MoveUserContactFomNotBuyersListToBuyersList($user));
    }
}
