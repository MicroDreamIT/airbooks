<?php
/**
 * This file is a part of MicroDreamIT
 * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * or visit https://microdreamit.com
 * Created by Shahanur Sharif.
 * User: sharif
 * Date: 1/6/2019
 * Time: 1:42 PM
 */

namespace App\Http;


use App\Cannedemail;
use App\Mail\AssetReviseEmail;
use App\Mail\CannedEmailModel;
use App\Mail\Common;
use App\Mail\ContactEmail;
use App\Mail\ObjectContentMail;
use App\Mail\SuggestionEmail;
use App\Mail\UserRegistrationCreate;
use Illuminate\Support\Facades\Mail;

class SendMail
{


    public function generic($email, $subject, $content, $url=null)
    {
        Mail::to($email)->send(new Common($subject, $content, $url));

    }

    public function suggestion($email, $subject, $content=[])
    {
        Mail::to($email)->send(new SuggestionEmail($subject, $content));

    }
    /**
     * @param $email
     * @param $subject
     * @param $object
     * object usually contain name, body, url
     */
    public function objectContent($email, $subject, $object)
    {
        Mail::to($email)->send(new ObjectContentMail($subject, $object));
    }

    public function sendVerifyEmail($user, $contact, $template=null)
    {

        Mail::to($user->email)->send(new UserRegistrationCreate($user, $contact, Cannedemail::where('message_type','user-registration')->first()));
    }

    public function cannedEmail($email, $name, $url, $template, $status=null)
    {
        $template = Cannedemail::where('message_type',$template)->first();
        Mail::to($email)->send(new CannedEmailModel($name, $url, $template, $status));
    }

    public function contactMail($subject)
    {
//        return request()->all();
//        $this->objectContent('support@airbook.aero', $subject, request()->all());
        Mail::to('support@airbook.aero')->send(new ContactEmail(request()->input('name'), request()->input('email'), request()->input('body')));
        $this->generic(request()->input('email'), 'thank you', 'We will get back to you after a while');
    }

    public function assetReviseEmail($email, $subject, $content, $url, $name)
    {
        Mail::to($email)->send(new AssetReviseEmail($subject, $content, $url, $name));
    }
}