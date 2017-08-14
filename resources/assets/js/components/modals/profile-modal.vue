<template>
	<div>
		<modal-container>
      <div slot="pt">
          <h2>Antes de continuar você deverá associar a conta da sua Cloud Drive à sua conta FF.</h2>
          <p>Por enquanto estamos apenas testando a drive Dropbox mas em breve estaremos prontos a usar qualquer tipo de Cloud Drive disponível.</p>
          <p>FF vai armazenar os seus arquivos originais na sua Cloud Drive pessoal e irá criar uma cópia comprimida com marca de água digital e ID. Esta cópia será armazenada no nosso servidor e estará totalmente disponível na nossa plataforma e partilhável para uso não comercial sem restrições.</p>
          <p>Nós utilizaremos a cópia comprimida para promover o seu trabalho. No entanto, você terá sempre controlo total sobre os seus arquivos.</p>
      </div>
      <div slot="br">
          <h2>Antes de continuar você deverá associar a conta da sua Cloud Drive à sua conta FF.</h2>
          <p>Por enquanto estamos usando apenas o Dropbox, mas em breve estaremos prontos a usar qualquer tipo de Cloud Drive disponível.</p>
          <p>FF vai armazenar os seus arquivos originais na sua Cloud Drive pessoal e irá criar uma cópia comprimida com marca d'água digital e ID. Esta cópia será armazenada no nosso servidor e estará totalmente disponível na nossa plataforma e compartilhável para uso não comercial sem restrições.</p>
          <p>Nós utilizaremos a cópia comprimida para promover o seu trabalho. No entanto, você terá sempre controle total sobre os seus arquivos.</p>
      </div>
      <div slot="es">
          <h2>Antes de continuar debe asociar la cuenta de su Cloud Drive a su cuenta FF.</h2>
          <p>Por el momento sólo estamos probando la unidad Dropbox pero pronto estaremos listos para usar cualquier tipo de Cloud Drive disponible.</p>
          <p>FF va a almacenar sus archivos originales en su Cloud Drive personal y creará una copia comprimida con marca de agua digital y ID. Esta copia será almacenada en nuestro servidor y estará totalmente disponible en nuestra plataforma y compartible para uso no comercial sin restricciones.</p>
          <p>Utilizaremos la copia comprimida para promover su trabajo. Sin embargo, siempre tendrá control total sobre sus archivos.</p>
      </div>
      <div slot="en">
        <h2>Before proceeding you must associate your Cloud Drive account to your FF account.</h2>
        <p>
          At the moment we are only testing Dropbox but very soon we will accept almost every type of cloud available. FF will store your original files in your Cloud Drive and create a compressed copy with digital watermark and ID. This copy will be stored on our server and fully available on our platform, shareable for non-commercial use with no restrictions. We’ll use the compressed file to promote your work. However, you will always have full control over it.
        </p>
      </div>
			
		</modal-container>
	</div>
</template>

<script>
export default {

  name: 'profile-modal',

  data () {
    return {

    };
  },
  mounted(){
  	let modalName='first_profile'
  	if(!localStorage.getItem(modalName))this.$store.commit('openModal',modalName)
  }
};
</script>

<style lang="scss" scoped>
</style>