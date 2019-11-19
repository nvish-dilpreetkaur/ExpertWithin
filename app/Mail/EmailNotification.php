<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $emaildata;
 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emaildata)
    {
        $this->emaildata = $emaildata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {	
		$viewTemplate = (empty($this->emaildata['template'])) ? 'notification' :  $this->emaildata['template'];
        //return $this->view('emails.notification');
        return $this->subject($this->emaildata['subject'])->view("emails.$viewTemplate");
    }
}
