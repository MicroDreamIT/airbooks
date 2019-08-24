<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssetReviseEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $content;
    public $url;
    public $name;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param $subject
     * @param $content
     * @param $url
     * @param $name
     */
    public function __construct($subject, $content, $url, $name)
    {
        //
        $this->subject = $subject;
        $this->content = $content;
        $this->url = $url;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->markdown('emails.user.assetReviseEmail');
    }
}
