<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Promise\EachPromise;
use GuzzleHttp\Client;

class AsyncTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:async';

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
        $client = new Client();

        $users = ['bot.png',
            'bot-landing.png',
            'bot-palette.png'
        ];
        $promises = (function () use ($users, $client) {
            foreach ($users as $user) {
                // don't forget using generator
                \Log::error($user);
                yield $client->getAsync('https://logo.bot/img/' . $user);
            }
        })();
        $eachPromise = new EachPromise($promises, [
            // how many concurrency we are use
            'concurrency' => 4,
            'fulfilled' => function ($response) {
                \Log::error('response', [$response]);
                if ($response->getStatusCode() == 200) {
                    $user = json_decode($response->getBody(), true);
                    // processing response of user here
                    \Log::error('user', [$user]);
                }
            },
            'rejected' => function ($reason) {
                // handle promise rejected here
            }
        ]);
        $eachPromise->promise()->wait();

        return 0;
    }
}
