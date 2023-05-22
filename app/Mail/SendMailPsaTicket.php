<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailPsaTicket extends Mailable
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
    public function __construct($assunto, $mensagem, $assinatura, $subMensagem = null)
    {
        $this->assunto = $assunto;
        $this->mensagem = $mensagem;
        $this->subMensagem = $subMensagem;
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
            ->view('mails.psa-tickets.create')
            ->with([
                'assunto' => $this->assunto,
                'mensagem' =>  $this->mensagem,
                'subMensagem' =>  $this->subMensagem,
                'assinatura' => $this->assinatura
            ]);
    }
}
