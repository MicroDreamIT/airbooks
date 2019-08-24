<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Common extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subject;
    public $url;

    /**
     * Create a new message instance.
     *
     * @param $subject
     * @param $data
     * @param $url
     */
    public function __construct($subject, $data, $url)
    {
        //
        $this->subject = $subject;
        $this->data = $data;
        if($url){
            $this->url = url($url);
        }else{
            $this->url=null;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        dd($this->data);
        return $this->subject($this->subject)->markdown('emails.common');
    }
}
