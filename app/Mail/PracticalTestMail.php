<?php
namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class PracticalTestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $practicalTest;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($practicalTest)
    {
        $this->practicalTest = $practicalTest;

        // Generate the PDF
        $this->pdf = FacadePdf::loadView('pdf.practical_test', compact('practicalTest'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Practical Test: ' . $this->practicalTest->title)
                    ->view('emails.practical_tests')
                    ->attachData($this->pdf->output(), 'practical_test.pdf');
    }
}

