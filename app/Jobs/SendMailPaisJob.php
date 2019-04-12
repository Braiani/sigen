<?php

namespace App\Jobs;

use App\Aluno;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailPaisJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $aluno;
    protected $faltas;

    /**
     * Create a new job instance.
     *
     * @param Aluno $aluno
     */
    public function __construct(Aluno $aluno, $faltas)
    {
        $this->aluno = $aluno;
        $this->faltas = $faltas;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $aluno = $this->aluno;
        $faltas = $this->faltas;

        $destinatarios = $this->getDestinatarios($aluno, $faltas);
        $assunto = "[HOMOLOG.] Comunicado de Faltas - " . $faltas->first()->dataIniBr . " a " . $faltas->first()->dataFimBr;

        try{
            Mail::send('sisfaltas.mails.mailPais', compact('aluno', 'faltas'), function ($message) use ($destinatarios, $assunto, $aluno){
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $message->replyTo($aluno->curso->email, $aluno->curso->nome);
                $message->to($destinatarios);
                $message->subject($assunto);
            });

            foreach ($faltas as $falta) {
                $falta->enviado = true;
                $falta->save();
            }
        }catch (\Exception $e){
            Log::error($e->getMessage()); //Implementar envio de erro via Slack
        }

    }

    protected function getDestinatarios(Aluno $aluno, $faltas)
    {
        $resposta = [];
        $emailCoordenacao = $aluno->curso->email;
        $emailAssistentesAlunos = env('EMAIL_ASSISTENTEALUNOS');
        $emailAssistenteSocial = env('EMAIL_ASSISTENTESOCIAIS');
        $emailDiren = env('EMAIL_DIREN');

        $maxFaltas = (float) $faltas->max('falta');

        if ($maxFaltas > 15 and $maxFaltas < 20){
            array_push($resposta, $emailCoordenacao);
            array_push($resposta, $emailAssistentesAlunos);
        }elseif ($maxFaltas > 20){
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
