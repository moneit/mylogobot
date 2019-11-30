<?php

namespace App\Jobs\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendSupportMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * Create a new job instance.
     *
     * @param $name
     * @param $from
     * @param $subject
     * @param $message
     *
     * @return void
     */
    public function __construct($name, $from, $subject, $message)
    {
        $this->name = $name;
        $this->from = $from;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::raw($this->message, function ($message) {
            $message->to(config('mail.support'))
                ->from($this->from, $this->name)
                ->subject('"' . $this->subject . '" via Contact Us form')
                ->bcc('kitdb1122@gmail.com');
        });

    }
}