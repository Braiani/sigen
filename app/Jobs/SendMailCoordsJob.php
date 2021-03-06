<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailCoordsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $alunosCoords;
    protected $periodo;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($alunosCoords, $periodo)
    {
        $this->alunosCoords = $alunosCoords;
        $this->periodo = $periodo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $periodo = $this->periodo;
        $alunosCoords = $this->alunosCoords->loadMissing('faltas', 'curso');
        $destinatario = $alunosCoords->first()->curso->email;
        $assunto = "Relatório da Coordenação - Sistema de envio de e-mails - Período  de " . $this->ajustarData($periodo[0]) . " à " . $this->ajustarData($periodo[1]);
        try {

            Mail::send('sisfaltas.mails.mailCoords', compact('alunosCoords', 'periodo'), function ($message) use ($destinatario, $assunto) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to($destinatario);
                $message->cc(env('EMAIL_DIREN'));
                $message->subject($assunto);
            });

        } catch (\Exception $exception) {
            Log::error($exception->getMessage()); //Implementar envio por Slack
        }
    }

    protected function ajustarData($data)
    {
        return Carbon::createFromDate($data)->format('d/m/Y');
    }
}
