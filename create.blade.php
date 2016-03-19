{{--
    Layout principal localização
    path : app/views/_layout/principal.blade.php
    @variantes
        $model, $router, $method
--}}

@extends('layouts.default')

@section('box-header')
    <h2>
        @if ($model->id) Editar registro @else  Novo Registro @endif
    </h2>
@stop

{{-- Ações da pagina | padrão: voltar e salvar --}}
@section('botoes-da-pagina')
    @include('acoes.acao-voltar')
    @include('acoes.acao-salvar')
@stop

{{-- Conteúdo da pagina form padrão --}}
@section('conteudo')

<?php
# Rota padrão do sistema
$route      = isset($route)?$route:[Meta::getController().'@store'];
$method     = isset($method)?$method:'POST';
$propriedes = [
	'action'   => $route
	, 'method' => $method
	, 'files'  => 'true'
	, 'class'  => 'form-horizontal'
	, 'role'   => 'form'
	, 'id'     => 'form-principal'
];
?>

    {{ Form::model($model, $propriedes) }}
        <fieldset>
            <legend> @if ($model->id) Editar registro @else  Novo Registro @endif </legend>

        @include("forms.inputs.text", [
          "name"        => "nome",
          "label"       => "Nome do arquivo",
        ])

        @include("forms.inputs.text", [
          "name"        => "versao",
          "label"       => "Versão",
        ])

        @if (!$model->id)
          <div class="form-group">
            {{ Form::label('arquivo', 'Arquivo', ['class'=>'col-sm-2 control-label']) }}
            <div class="col-sm-6">
                {{ Form::file('arquivo', ['class'=>'form-control']) }}
            </div>
          </div>
        @endif

        {{-- input type text --}}
        @include("forms.inputs.textarea", [
          "name"        => "descricao",
          "label"       => "Descricao"
        ])

        </fieldset>
    {{ Form::close() }}
@stop