<template>
<div>
	<modal-container>
		<div slot="pt">
		  	<h1>Caro(a) amigo(a): <br/> Bem-vindo(a) ao FrontFiles</h1>
			<p>
				Você está prestes a aceder à versão Beta da Plataforma FrontFiles. Tenha em atenção que esta área está em construção pela comunidade de usuários e temos muito prazer que nos ajude a melhorar a sua qualidade.
			</p>
			<h2>FrontFiles é uma comunidade web global de repórteres e jornalistas livres</h2>
			<p>
				Ao tornar-se um FrontFiler você fará parte de um grupo mundial de pessoas empenhadas em construir um novo modelo de fornecimento de notícias e informação, produzidos pelos usuários e baseados em imagens, vídeos e relatos verdadeiros com efetiva confirmação dos factos.
				Através do trabalho colaborativo – partilha de informação, tecnologia, equipamentos, alojamento, transporte, etc…
			 </p>
			 <h2>Empoderamos a comunidade e tornamos o nosso trabalho mais fácil e eficiente.</h2>
			 <p>
				Ao vender os seus arquivos editoriais de imagem, vídeo ou ilustração de uma forma rápida, simples e sem burocracia o usuário se empodera financeiramente. Este é o começo de uma longa e poderosa viagem. Vamos fazê-la juntos.
			 </p>
		</div>
		<div slot="br">
	  		amigo(a): <br/> Bem-vindo(a) ao FrontFiles</h1>
			<p>
				Você está prestes a acessar a versão Beta da Plataforma FrontFiles. 
				Tenha em mente que esta área está em construção pela comunidade de usuários e temos o enorme prazer de contar com a sua colaboração para ajudar a plataforma a melhorar sua performance.

			</p>
			<h2>FrontFiles é uma comunidade web global de jornalistas e midialivristas.</h2>
			<p>
				Ao tornar-se um FrontFiler você fará parte de um grupo mundial de pessoas empenhadas em construir um novo modelo de fornecimento de notícias e informações, produzidas pelos usuários e baseadas em imagens, vídeos e relatos. Através do trabalho colaborativo - compartilhamento de dados, tecnologia, equipamentos, alojamento, transporte, etc…
			 </p>
			 <h2>Visamos empoderar a comunidade e tornar nosso trabalho mais fácil e eficiente.</h2>
			 <p>
				Ao vender seus arquivos de imagem, vídeo ou ilustração de uma forma rápida, simples e sem burocracia, o usuário se empodera financeiramente. Este é o começo de uma longa e poderosa viagem. Vamos fazê-la juntos.
			 </p>
		</div>
		<div slot="es">
		  	<h1>Estimado amigo: <br/> Bienvenido a FrontFiles</h1>
			<p>
				 Está a punto de ingresar a la versión Beta de la plataforma FrontFiles Tenga en cuenta que este área está en construcción por la comunidad de usuarios y estamos muy agradecidos por su ayuda para mejorar su calidad.

			</p>
			<h2>FrontFiles es una comunidad web global de periodistas y medios livres de comunicación.</h2>
			<p>
				 Al convertirse en un FrontFiler, usted formará parte de un grupo mundial de personas comprometidas en construir un nuevo modelo de suministro de noticias e informaciones, producidas por los usuarios y basadas en imágenes, vídeos y relatos verdaderos, con efectiva confirmación de los hechos. A través del trabajo colaborativo - compartir datos, tecnologías, equipamientos, alojamiento, transporte, etc ...
			 </p>
			 <h2>Buscamos empoderar a la comunidad y hacer nuestro trabajo más fácil y eficiente.</h2>
			 <p>
				 Al vender sus archivos de imagen, vídeo o ilustración de una forma rápida, sencilla y sin burocracia, el usuario se empodera financieramente. Este es el comienzo de un largo y poderoso viaje. Vamos a hacerlo juntos.
			 </p>
		</div>
		<div slot="en">
        	<h1>Dear friend: <br />Welcome to FrontFiles</h1>
			<p>
				 Thank you for joining us on this Beta version and Platform testing. Please note that this is a community work-in-progress area. We are very pleased that you are helping us to improve its quality. 
			</p>
			<h2>FrontFiles is a global web-based community of free reporters and journalists.</h2>
			<p>
				 By becoming a FrontFiler you will be part of a worldwide group of people committed to building a new model for news and information sourcing, produced by the users and based on true images, footage and reports and effective fact checking. By collaborating - sharing information, technology, equipment, lodging, transportation and more.
			 </p>
			 <h2>We empower ourselves and make our jobs easier.</h2>
			 <p>
				 By selling our files in a way that’s fast, easy and free of bureaucracy, we find financial empowerment. This is the beginning of a long and powerful journey. Let’s do it together.
			 </p>
        </div>		
	</modal-container>
</div>
</template>

<script>
export default {

	name: 'register-modal',
	data () {
		return {

		};
	},
	mounted(){
		let modalName = 'register'
		if(!localStorage.getItem(modalName))this.$store.commit('openModal',modalName)
	}
};
</script>

<style lang="css" scoped>
</style>