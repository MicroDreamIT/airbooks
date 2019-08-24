<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ObjectContentMail extends Mailable
{
    use Queueable, SerializesModels;
    public $object;
    public $subject;
    public $name;
    public $body;
    public $url;
    public $email;

    /**
     * Create a new message instance.
     *
     * @param $subject
     * @param $object
     */
    public function __construct($subject, $object)
    {
        //
        $this->subject = $subject;
        $this->object = $object;
        if (count($this->object)){
            $this->processObject($object);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        dd($this->email);
        if(!$this->email){
            return $this->subject($this->subject)->markdown('emails.ObjectContentMail');
        }else{
            return $this->subject($this->subject)->markdown('emails.ObjectContentMail');
        }
    }

    /**
     * @param $object
     */
    public function processObject($object)
    {

            $this->name = $object['name'];
            $this->body = $object['body'];
            if (array_key_exists('url', $object)) {
                $this->url = $object['url']; //url can be nullable
            } else {
                $this->url = null;
            }
            if(array_key_exists('email', $object)){
                $this->email=$object['email'];
            }else{
                $this->email=null;
            }

    }
}
