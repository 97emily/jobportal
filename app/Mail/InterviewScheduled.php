<?php

namespace App\Mail;

use App\Models\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewScheduled extends Mailable
{
    use Queueable, SerializesModels;

    public $interview;
    public $applicant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Interview $interview, $applicant)
    {
        $this->interview = $interview;
        $this->applicant = $applicant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.interview_scheduled')
                    ->with([
                        'interview' => $this->interview,
                        'applicant' => $this->applicant,
                    ]);
    }
}
