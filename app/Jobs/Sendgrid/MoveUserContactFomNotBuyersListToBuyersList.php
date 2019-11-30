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
use App\Services\Sendgrid\Commands\Contacts\SearchContactByEmailCommand;
use App\Services\Sendgrid\Commands\Contacts\AddUpdateContactsCommand;

class MoveUserContactFomNotBuyersListToBuyersList implements ShouldQueue
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
            $command = new SearchContactByEmailCommand($this->user->email);
            $result = $command->execute();

            if ($result['status'] === 200) {
                // success
                $contacts = $result['payload']->result;
                if (count($contacts) === 1) {
                    $contact = $contacts[0];
                    $notBuyerListId = SendgridList::notBuyers()->firstOrFail()->id;
                    if (count($contact->list_ids) === 1) {
                        if ($contact->list_ids[0] === $notBuyerListId) {
                            $buyerListId = SendgridList::buyers()->firstOrFail()->id;

                            $command = new AddUpdateContactsCommand([$buyerListId], [$contact]);
                            $command->execute();
                        } else {
                            throw new \Exception('The user is included in 1 list but not in NotBuyers list - ' . $this->user->email . $contact->list_ids[0]);
                        }
                    } else {
                        throw new \Exception('The user is not included in 1 list - ' . $this->user->email . json_encode($contact->list_ids));
                    }
                } else {
                    throw new \Exception('Got not unique contacts from 1 email - ' . $this->user->email);
                }
            } else {
                throw new \Exception('Search contact by email request failed - ' . $this->user->email . ' - ' . $result['payload']->message);
            }
        } catch (\Exception $e) {
            // todo: send notification email : failed to move sendgrid automation contact between list
            \Log::error('Failed to move sendgrid automation contact between list: ' . $this->user->id, [$e->getMessage()]);
        }
    }
}
