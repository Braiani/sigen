<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <style>
        table {
            width: 100%;
        }

        table, th, td {
            border: 1px solid black;
        }

        td {
            vertical-align: middle !important;
        }
    </style>
    <meta charset="UTF-8">
    <title>
        Comunicado de Faltas - {{ Carbon\Carbon::createFromDate($periodo[0])->format('d/m/Y') }}
        a {{ Carbon\Carbon::createFromDate($periodo[1])->format('d/m/Y') }} - Relatório Coordenação
    </title>
</head>
<body>
{{--<img src="{{ $message->embed(public_path() . '/img/email-head.png') }}" width="420" height="61"><br>--}}
<img src="{{ asset('/img/email-head.png') }}" width="420" height="61"><br>
<p>Prezado Coordenador!</p>
<p>
    Informamos que no período entre {{ Carbon\Carbon::createFromDate($periodo[0])->format('d/m/Y') }}
    e {{ Carbon\Carbon::createFromDate($periodo[1])->format('d/m/Y') }}
    os responsáveis dos seguintes alunos foram comunicados por e-mail:
</p>
<p>
<table>
    <thead>
    <th>Nome</th>
    <th>Curso</th>
    <th>Maior Porcentagem de Faltas</th>
    <th>Período</th>
    <th>Data de envio do e-mail</th>
    </thead>
    <tbody>
    @php
        $sorted = $alunosCoords->sortByDesc(function ($alunos, $key){
            return $alunos->faltas->max('falta');
        });
    @endphp
    @foreach($sorted as $aluno)
        <tr>
            <td>{{ strtoupper($aluno->nome) }}</td>
            <td>{{ $aluno->curso->nome }}</td>
            <td>
                {{ number_format($aluno->faltas->where('data_fim', Carbon\Carbon::createFromDate($periodo[1]))->max('falta'), 1, ',', '.') }} %
            </td>
            <td>
                De: {{ Carbon\Carbon::createFromDate($periodo[0])->format('d/m/Y') }}
                à {{ Carbon\Carbon::createFromDate($periodo[1])->format('d/m/Y') }}
            </td>
            <td>
                {{ $aluno->faltas->where('data_fim', Carbon\Carbon::createFromDate($periodo[1]))->last()->updated_at->format('d/m/Y H:i:s') }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</p>

<p>
    <b>Obs:</b> A Lei de Diretrizes e Bases da Educação Nacional 9.394/96, Art. 24, Inciso VI, prevê "o controle de
    freqüência
    fica a cargo da escola, conforme o disposto no seu regimento e nas normas do respectivo sistema de ensino, exigida a
    freqüência mínima de setenta e cinco por cento do total de horas letivas para aprovação", sendo facultado ao
    estudante atingir o percentual de 25% de faltas no semestre.
</p>

<p>Atenciosamente,</p>

<div style="color: #274e13; font-family: Verdana, sans-serif; font-size: small; margin-top:0px;line-height:8px">
    <p>
        SIGEN - Sistema de Gestão do Ensino
    </p>
    <p>
        <b>Equipe Direção de Ensino do <i>Campus</i> Campo Grande</b>
    </p>
    <p>
        Rua Taquari nº 831, Santo Antônio, Campo Grande/MS 79100-510
    </p>
    <p>
        (67) 3357-8511 •
        <a href="http://www.ifms.edu.br/" target="_blank">Site</a> •
        <a href="http://facebook.com/ifms.cg" target="_blank">Facebook</a> •
        <a href="http://youtube.com/ifmscomunica" target="_blank">Youtube</a>
    </p>
</div>
</body>
</html>