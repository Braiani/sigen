<?php

namespace App\Jobs;

use App\Aluno;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendMailPaisJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $alunos;

    /**
     * Create a new job instance.
     *
     * @param $alunos
     */
    public function __construct($alunos)
    {
        $this->alunos = $alunos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $alunos = $this->alunos;

        foreach ($alunos as $aluno) {
            if ($aluno->faltas->max('falta') > 0){
                $destinatarios = $this->getDestinatarios($aluno);
                $assunto = "Comunicado de Faltas - " . $aluno->faltas->first()->dataIniBr . " a " . $aluno->faltas->first()->dataFimBr;

                Mail::send('sisfaltas.mails.mailPais', ['aluno' => $aluno], function ($message) use ($destinatarios, $assunto){
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($destinatarios);
                    $message->subject($assunto);
                });
            }

        }
    }

    protected function getDestinatarios(Aluno $aluno)
    {
        $resposta = [];
        $emailCoordenacao = $aluno->curso->email;
        $emailAssistentesAlunos = env('EMAIL_ASSISTENTEALUNOS');
        $emailAssistenteSocial = env('EMAIL_ASSISTENTESOCIAIS');
        $emailDiren = env('EMAIL_DIREN');

        if ($aluno->faltas->max('falta') > 15 and $aluno->faltas->max('falta') < 20){
            array_push($resposta, $emailCoordenacao);
            array_push($resposta, $emailAssistentesAlunos);
        }elseif ($aluno->faltas->max('falta') > 20){
            array_push($resposta, $emailDiren);
            $assistentes = explode(',', $emailAssistenteSocial);
            foreach ($assistentes as $assistente) {
                array_push($resposta, $assistente);
            }
        }

        array_push($resposta, $aluno->email);

        return $resposta;
    }
}
