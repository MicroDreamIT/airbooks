<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuggestionEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $subject;
    public $category;
    public $manufacturer;
    public $type;
    public $model;
    public $entity_type;

    /**
     * Create a new message instance.
     *
     * @param $subject
     * @param $data
     */
    public function __construct($subject, $data=[])
    {
        //
        $this->subject = $subject;
        $this->category = $data['category'];
        $this->manufacturer = $data['manufacturer'];
        $this->type = $data['type'];
        $this->model = $data['model'];
        $this->entity_type = $data['entity_type'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.suggestion');
    }
}
