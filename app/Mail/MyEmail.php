<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Str;

class MyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $course;

    public function __construct($course)
    {
        $this->course = $course;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjectName = "ĐĂNG KÝ THÀNH CÔNG KHÓA HỌC_".Str::upper($this->course->name) ." TẠI CODERX"; 
        $fromEmail = env('MAIL_FROM_ADDRESS');
        return new Envelope(
            from: new Address($fromEmail, 'CoderX'),
            subject: $subjectName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'clients.template',
            with: [
                'messageMail' => $this->course->name,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        //cach 1 fromStorage(se tu hieufile nam trong storage)
        // $filePath = "/public/uploads/TEST.pdf";
        // return [
        //     Attachment::fromStorage($filePath)
        // ];
        //cach 2 fromPath
        // $filePath = public_path("/storage/uploads/MVC.webp");
        $filePath = public_path($this->course->letter);
        $outlineName = "ĐỀ_CƯƠNG_KHÓA_HỌC_".Str::upper($this->course->name).'.pdf'; 
        return [
            Attachment::fromPath($filePath)->as($outlineName)
            ->withMime('application/pdf'),
        ];
    }
}
