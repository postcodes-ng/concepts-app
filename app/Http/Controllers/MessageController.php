<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailBuilder;
use App\Services\MessageService;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    /**
     *
     * @var MessageService
     */
    private $messageService;

    /**
     * Creates a new controller instance.
     *
     * @return void
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
        $this->middleware('web');
        $this->middleware('ajax');
    }

    /**
     * Search by postcode.
     *
     * @param Request $request
     * @return array
     */
    public function sendContactMessage(Request $request) {
        if (!$this->messageService->contactFormIsValid($request->all())) {
            return ['error' => 'Contains missing or invalid field'];
        }

        Mail::to(config('mail.contact_form_to_address'))->send(new SendMailBuilder($request->all()));

        return ['message' => 'Message Sent Successfully'];
    }


}
