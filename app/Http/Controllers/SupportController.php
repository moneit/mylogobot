<?php

namespace App\Http\Controllers;

use App\Support;
use App\Http\Requests\SupportRequest;
use App\Services\Support\Service as SupportService;

class SupportController extends Controller
{
    /**
     * @var SupportService
     */
    private $supportService;

    public function __construct(SupportService  $supportService)
    {
        $this->supportService = $supportService;
    }

    public function support(SupportRequest $request)
    {
        // firstly need to verify that the user is human by verifying with google recaptcha
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $secret = env('GOOGLE_RECAPTCHA_SECRET_KEY');
        $response = $request->get('g-recaptcha-response');
        if (empty($response)) {
            \Session::flash('message', 'Google recaptcha is not checked.');
            \Session::flash('status', 'failure');

            return \Redirect::back();
        } else {
            $data = array('secret' => $secret, 'response' => $response);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $verifyResponse = curl_exec($ch);
            curl_close($ch);

            $responseData = json_decode($verifyResponse);

            if ($responseData->success) {
                $supportRequest = $this->store($request);

                $this->supportService->sendMail(
                    $supportRequest->name,
                    $supportRequest->email,
                    $supportRequest->subject,
                    $supportRequest->message
                );

                \Session::flash('message', 'Your message has been sent to ' . config('mail.support') .'.');
                \Session::flash('status', 'success');

                return \Redirect::back();
            } else {
                \Session::flash('message', 'Google recaptcha verification failed.');
                \Session::flash('status', 'failure');

                return \Redirect::back();
            }
        }
    }

    public function store(SupportRequest $request)
    {
        $support = new Support([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'subject' => $request->get('subject'),
            'message' => $request->get('message'),
        ]);
        $support->save();

        return $support;
    }
}
