<?php
/**
 * Controller Manuais
 * @name Manuais
 * @map
 * @author  Proesc
 */
class ManuaisController extends ResourceController {
	/**
	 * Nome do model
	 *
	 * @var string
	 */
	protected static $model = 'Manual';

	public function index() {

		$pesquisa = (Input::get('pesquisa'))?strtoupper(Input::get('pesquisa')):'';

		$manuais = Manual::retornarManuais($pesquisa);

		$model  = static ::$model;
		$models = static ::$models;

		return $this->makeView('index')->with([
				'models'      => $models,
				'model_class' => static ::$model,
				'manuais'    => $manuais
			]);

	}

	public function store() {

		$input = Input::all();

		$validator = Validator::make($input, Manual::$rules);

		if ($validator->fails()) {
			return Redirect::action('ManuaisController@create')->withErrors($validator)->withInput();
		}

		// Lógica para salvar o arquivo se existir
		if (Input::hasFile('arquivo')) {
			// Lógica para salvar o arquivo
			$arquivo = Input::file('arquivo');
			// Seleciona o caminho relativo a salvar o arquivo
			$directory = public_path().'/arquivos/manuais';
			$extension = $arquivo->getClientOriginalExtension();
			// Cria um hash pra salvar na coluna 'arquivo' na tabela de manuais
			$nome_manual = sha1(Auth::user()->id.time()).".{$extension}";
			// Batucada que salva o arquivo em manuais
			$arquivo->move($directory, $nome_manual);
			$arquivo = $directory.$nome_manual;
		}

		$manual = new Manual($input);
		$manual->arquivo = $nome_manual;
		$manual->save();

		return Redirect::action('ManuaisController@index');
	}

}