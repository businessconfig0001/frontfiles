@extends('layouts.app')

@section('content')

<user-profile :user="{{ $user }}" :files="{{ $files }}"></user-profile>

@endsection

@section('modals')
	<modal-container>
		<div slot="pt">
		  	<p>Você é agora um FrontFiler oficial e nós estamos prontos para receber o seu material editorial: Vídeos, Fotos ou Ilustrações.</p>
			<p>Você poderá completar os dados do seu perfil quando desejar.</p>
			<p>Depois de subir os seus arquivos, eles ficarão disponíveis para venda e para partilha (as cópias comprimidas).</p>
			<p>Durante esta fase Beta. Os arquivos podem ser vendidos diretamente por nós ao cliente se houver urgência e os assuntos forem relevantes. No entanto você decidirá se deseja vender ou não e definir o preço para todos os seus arquivos.</p>
			<p>Na próxima fase da plataforma você terá controlo total sobre as vendas de uma forma automática e negociando diretamente com o comprador.</p>
		</div>
		<div slot="br">
		  	<p>Você é agora um FrontFiler oficial e nós estamos prontos para receber o seu material editorial: vídeos, fotos ou ilustrações.</p>
			<p>Você poderá completar os dados do seu perfil quando desejar.</p>
			<p>Depois de subir os seus arquivos, eles ficarão disponíveis para venda e para compartilhamento (as cópias comprimidas).</p>
			<p>Durante esta fase Beta, os arquivos podem ser vendidos diretamente por nós ao cliente se houver urgência e os assuntos forem relevantes. No entanto, você decidirá se deseja vender ou não e definir o preço para todos os seus arquivos.</p>
			<p>Na próxima fase da plataforma você terá controle total sobre as vendas de uma forma automática e negociando diretamente com o comprador.</p>

		</div>
		<div slot="es">
		  	<p>Usted es ahora un FrontFiler oficial y estamos listos para recibir su material editorial: vídeos, fotos o ilustraciones.</p>
			<p>Puede completar los datos de su perfil cuando desee.</p>
			<p>Después de subir sus archivos, estarán disponibles para la venta y para compartir (las copias comprimidas).</p>
			<p>Durante esta fase Beta. Los archivos pueden ser vendidos directamente por nosotros al cliente si hay urgencia y los asuntos son relevantes. Sin embargo, usted decidirá si desea vender o no y establecer el precio para todos sus archivos.</p>
			<p>En la próxima fase de la plataforma usted tendrá control total sobre las ventas de una forma automática y negociando directamente con el comprador.</p>

		</div>
		<div slot="en">
			<p>You are now an official FrontFiler and we are ready to start receiving your editorial footage, images or illustrations.</p>
			<p>You can complete your profile information whenever you want.</p>
			<p>After you upload your files, they will be available for sale and for sharing (the compressed copy).</p>
			<p>During this Beta phase, files can be sold through our commercial area directly to the client, and only if they show urgent relevancy.  However, you decide whether you wish to sell or not, as well as set the price for all of your files.</p>
			<p>In the next platform’s phase you will have full control over the sales , which will be automatic and direct from you to the buyer.</p>

		</div>
	</modal-container>
@endsection