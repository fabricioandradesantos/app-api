<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailRegistration extends Mailable
{
    use Queueable, SerializesModels;

    private $assunto;
    private $mensagem;
    private $assinatura;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assunto, $mensagem, $assinatura)
    {
        $this->assunto = $assunto;
        $this->mensagem = $mensagem;
        $this->assinatura = $assinatura;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->assunto)
            ->view('mails.registration')
            ->with([
                'assunto' => $this->assunto,
                'mensagem' =>  $this->mensagem,
                'assinatura' => $this->assinatura
            ]);
    }
}
