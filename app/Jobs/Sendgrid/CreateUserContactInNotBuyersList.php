<?php

namespace App\Jobs\Sendgrid;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use App\SendgridList;
use App\UserSendgridContact;
use App\Services\Sendgrid\Commands\Contacts\AddUpdateContactsCommand;

class CreateUserContactInNotBuyersList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User $user
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $notBuyersList = SendgridList::notBuyers()->firstOrFail();

            $command = new AddUpdateContactsCommand([$notBuyersList->id], [
                [
                    'email' => $this->user->email
                ]
            ]);
            $result = $command->execute();

            if ($result['status'] === 202 || $result['status'] === 200) {
                // success
            } else {
                \Log::error('Failed to add user contact to sendgrid Not Buyers list.', [$this->user->id]); // todo send notification email to me or Miguel
            }
        } catch (\Exception $e) {
            // todo: send notification email : failed to create sendgrid automation contact
            \Log::error('failed to create sendgrid automation contact ' . $this->user->id, [$e->getMessage()]);
        }
    }
}
