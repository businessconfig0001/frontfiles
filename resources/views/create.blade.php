@extends('layouts.app')

@section('content')
    <section class="form-container">
	    <drag-n-drop :dropbox={{ $dropbox_token}}></drag-n-drop>
    </section>
@endsection

@section('modals')
<modal-container>
	<div slot="pt">
	  	<h2>Para uma indexação perfeita, é extremamente importante que você descreva e atribua “tags” com grande precisão.</h2>
		<p>Forneça um título curto e uma descrição detalhada do evento.<br/>
		Palavras chave e “tags” tornarão mais fácil a sua descoberta em uma busca.</br>
		Deverá tentar responder às questões #quem, #o quê, #onde, #quando, #porquê, #como.
		</p>
		 
		<p>Para nos enviar o seu retorno, sugestões e dúvidas, por favor aceda ao nosso grupo de Telegram ou use o seguinte e-mail:<br/>
		<a href="mailto:betatesting@frontfiles.com">betatesting@frontfiles.com</a></p>

	</div>
	<div slot="br">
	  	<h2>Para uma indexação perfeita, é extremamente importante que você descreva e atribua "tags" com grande precisão. </h2>
		<p>Forneça um título curto e uma descrição detalhada do evento.<br/>
		Palavras chave e "tags" tornarão mais fácil a sua descoberta em uma busca.<br/>
		Ao subir, você deverá tentar responder às questões #quem, #o que, #onde, #quando, #porquê, #como. 
		</p>
		<p>Para nos enviar retorno, sugestões e dúvidas, por favor acesse o nosso grupo de Telegram ou use o seguinte e-mail:<br/>
		<a href="mailto:betatesting@frontfiles.com">betatesting@frontfiles.com</a></p>
	</div>
	<div slot="es">
	  	<h2>Para una indexación perfecta, es sumamente importante que usted describa y asigne "tags" con gran precisión.</h2>
		<p>Proporcione un título corto y una descripción detallada del evento.<br/>
		Las palabras clave y los "tags" harán más fácil su hallazgo en una búsqueda.<br/>
		Deberá tratar de responder a las preguntas #quién, #qué,  #dónde, #cuándo, #por qué, #cómo.
		</p>
		<p>Para escribirnos sugerencias y dudas, por favor acceda a nuestro grupo de Telegram o utilice el siguiente e-mail:<br/>
		<a href="mailto:betatesting@frontfiles.com">betatesting@frontfiles.com</a></p>
	</div>
	<div slot="en">
		<h2>For optimal indexing, it is extremely important that you describe and tag your material very precisely.</h2>
		<p>Provide a short title and an accurate description of the event. <br/>
		Key words / tags will make it easier to find your work in a search.<br/>
		You must try to answer basic questions like #who, #what, #where, #when, #why, #how.
		</p>
		<p>For feedback and further questions please use our telegram channel or the following e-mail address:<br/>
		<a href="mailto:betatesting@frontfiles.com">betatesting@frontfiles.com</a></p>
	</div>

</modal-container>
@endsection