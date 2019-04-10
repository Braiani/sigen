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
    </style>
    <meta charset="UTF-8">
    <title>Comunicado de Faltas - {{ $aluno->faltas->first()->dataIniBr }}
        a {{ $aluno->faltas->first()->dataFimBr }}</title>
</head>
<body>
{{--<img src="{{ $message->embed(public_path() . '/img/email-head.png') }}" width="420" height="61"><br>--}}
<img src="{{ asset('/img/email-head.png') }}" width="420" height="61"><br>
<p>Prezados pais e/ou responsáveis, bom dia!</p>
<p>Informamos que no período entre {{ $aluno->faltas->first()->dataIniBr }} e {{ $aluno->faltas->first()->dataFimBr }}
    seu/sua filho(a) apresentou o seguinte percentual de faltas:</p>
<p>
<table>
    <thead>
    <th>Nome</th>
    <th>Curso</th>
    <th>Disciplinas</th>
    <th>Porcentagem de Faltas</th>
    <th>Período</th>
    </thead>
    <tbody>
    @foreach($aluno->faltas as $falta)
        <tr>
            <td>{{ strtoupper($aluno->nome) }}</td>
            <td>{{ $aluno->curso->nome }}</td>
            <td>
                {{ strtoupper($falta->disciplina) }}
            </td>
            <td>
                {{ $falta->falta }}%
            </td>
            <td>
                De {{ $falta->dataIniBr }}
                até {{ $falta->dataFimBr }}
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

<p>Qualquer dúvida entrar em contato com: <a href="mailto:{{ $aluno->curso->email }}">{{ $aluno->curso->email }}</a> ou
    <b>3357-8505</b>.</p>

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