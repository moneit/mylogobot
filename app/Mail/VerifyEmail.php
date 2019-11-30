<?php

namespace App\Mail;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * VerifyEmail constructor.
     *
     * @param User $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = \URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), ['id' => $this->user->getKey()]
        );

        return $this->markdown('mails.auth.verification')
            ->with([
                'user' => $this->user,
                'url' => $url,
            ]);
    }
}
