<?php

namespace App\Mail;

use App\Http\GlobalMethods;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CannedEmailModel extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $url;
    public $template;
    public $location;
    public $status;

    /**
     * Create a new message instance.
     *
     * @param $name
     * @param $url
     * @param $template
     * @param null $status
     */
    public function __construct($name, $url, $template, $status=null)
    {
        //
        $this->name = $name;
        $this->url = $url;
        $this->template = $template;
        $this->location =  str_replace('.blade.php', '', str_replace('/', '.', str_replace('resources/views/','', $template['location'])));
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->template['sending_email'], 'Airbook')->subject($this->template['subject'])
            ->markdown($this->location);
    }
}
