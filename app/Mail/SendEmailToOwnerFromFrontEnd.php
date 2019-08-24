<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToOwnerFromFrontEnd extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $user;
    public $message;

    /**
     * Create a new message instance.
     *
     * @param $data
     * @param $user
     * @param $message
     */
    public function __construct($data, $user, $message)
    {
        //
        $this->data = $data;
        $this->user = $user;
        $this->message = $message;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        if($this->data['modelType']==='part'){
            return $this->from('no-reply@airbook.aero', 'Airbook')
                ->subject('RFQ | Airbook')
                ->markdown('emails.frontend.RFQEmail');
        }else{
            return $this->from('no-reply@airbook.aero', 'Airbook')
                ->subject($this->data['modelType']==='contact'? 'New message | Airbook': 'New lead | Airbook')
                ->markdown('emails.frontend.SendEmailToOwnerFromFrontEnd');
        }


    }
}
