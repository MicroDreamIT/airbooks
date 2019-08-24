<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RFQPartsEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $message;
    public $values;

    /**
     * Create a new message instance.
     *
     * @param $message
     * @param $values
     */
    public function __construct($message, $values)
    {
        //
        $this->message = $message;
        $this->values = $values;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@airbook.aero', 'Airbook')
            ->subject('RFQ | Airbook')
            ->markdown('emails.frontend.rfqPartsEmail');
    }
}
//return $this->from('no-reply@airbook.aero', 'Airbook')
//    ->subject('RFQ | Airbook')
//    ->markdown('emails.frontend.RFQEmail');