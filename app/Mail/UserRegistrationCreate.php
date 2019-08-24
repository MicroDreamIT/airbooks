<?php

namespace App\Mail;

use App\Contact;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegistrationCreate extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * This file is a part of MicroDreamIT
     * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
     *
     * For the full copyright and license information, please view the LICENSE
     * or visit https://microdreamit.com
     * @var User
     */
    public $user;
    /**
     * This file is a part of MicroDreamIT
     * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
     *
     * For the full copyright and license information, please view the LICENSE
     * or visit https://microdreamit.com
     * @var Contact
     */
    public $contact;
    public $url;
    public $template;
    public $name;
    public $location;


    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Contact $contact
     * @param $template
     */
    public function __construct(User $user, Contact $contact, $template)
    {
        //
        $this->user = $user;
        $this->contact = $contact;
        $this->url = url('email-verification?id='.$this->user->id.'&token='.$this->user->email_verified);
        $this->template = $template;
        $this->name = $contact->first_name.' '.$contact->last_name;

        $this->location = $location = str_replace('.blade.php', '', str_replace('/', '.', str_replace('resources/views/','', $template['location'])));
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
