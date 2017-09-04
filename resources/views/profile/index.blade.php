@extends('layouts.app')

@section('content')

    <div class="container profile">
        <h1 class="auth-title">Dashboard</h1>
        <div class="row storage">
            <ul>
                <li class="box">
                    <img  class="logo" src="/images/dropbox_glyph_blue.svg" alt="">
                    <h3 class="title">Dropbox</h3>
                    @if($user->dropbox_token)
                        <p>Dropbox connected!</p>
                    @else
                        <p>Dropbox not configured!</p>
                        <a href="{{ route('profile.dropbox') }}" class="btn btn-primary">Connect to your Dropbox</a>
                    @endif
                </li>
                <li class="box">
                    <img  class="logo avatar" src="{{$user->avatar}}" alt="">
                    <h3 class="title">Your profile</h3>
                    <p>Go and edit your profile</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Go to your profile</a>
                </li>
                <li class="box">
                    <div class="logo">
                      <img src="/images/logo2x.png" alt="">
                     </div>   
                    <h3 class="title">Public profile</h3>
                    <p>View your profile as another user</p>
                    <a href="{{ url($user->path()) }}"  target="_blank" class="btn btn-primary">Go to your public profile</a>
                </li>
            </ul>
            
            
        </div>

    </div>
    
@endsection

@section('modals')
    <profile-modal>
        <modal-container>
          <div slot="pt">
              <h2>Antes de continuar você deverá associar a conta da sua Cloud Drive à sua conta FF.</h2>
              <p>Por enquanto estamos apenas testando a drive Dropbox mas em breve estaremos prontos a usar qualquer tipo de Cloud Drive disponível.</p>
              <p>FF vai armazenar os seus arquivos originais na sua Cloud Drive pessoal e irá criar uma cópia comprimida com marca de água digital e ID. Esta cópia será armazenada no nosso servidor e estará totalmente disponível na nossa plataforma e partilhável para uso não comercial sem restrições.</p>
              <p>Nós utilizaremos a cópia comprimida para promover o seu trabalho. No entanto, você terá sempre controlo total sobre os seus arquivos.</p>
              <a href="{{ route('profile.dropbox') }}" class="btn btn-primary dropbox">Connect to your Dropbox</a>
          </div>
          <div slot="br">
              <h2>Antes de continuar você deverá associar a conta da sua Cloud Drive à sua conta FF.</h2>
              <p>Por enquanto estamos usando apenas o Dropbox, mas em breve estaremos prontos a usar qualquer tipo de Cloud Drive disponível.</p>
              <p>FF vai armazenar os seus arquivos originais na sua Cloud Drive pessoal e irá criar uma cópia comprimida com marca d'água digital e ID. Esta cópia será armazenada no nosso servidor e estará totalmente disponível na nossa plataforma e compartilhável para uso não comercial sem restrições.</p>
              <p>Nós utilizaremos a cópia comprimida para promover o seu trabalho. No entanto, você terá sempre controle total sobre os seus arquivos.</p>
              <a href="{{ route('profile.dropbox') }}" class="btn btn-primary dropbox">Connect to your Dropbox</a>
          </div>
          <div slot="es">
              <h2>Antes de continuar debe asociar la cuenta de su Cloud Drive a su cuenta FF.</h2>
              <p>Por el momento sólo estamos probando la unidad Dropbox pero pronto estaremos listos para usar cualquier tipo de Cloud Drive disponible.</p>
              <p>FF va a almacenar sus archivos originales en su Cloud Drive personal y creará una copia comprimida con marca de agua digital y ID. Esta copia será almacenada en nuestro servidor y estará totalmente disponible en nuestra plataforma y compartible para uso no comercial sin restricciones.</p>
              <p>Utilizaremos la copia comprimida para promover su trabajo. Sin embargo, siempre tendrá control total sobre sus archivos.</p>
              <a href="{{ route('profile.dropbox') }}" class="btn btn-primary dropbox">Connect to your Dropbox</a>
          </div>
          <div slot="en">
            <h2>Before proceeding you must associate your Cloud Drive account to your FF account.</h2>
            <p>
              At the moment we are only testing Dropbox but very soon we will accept almost every type of cloud available. FF will store your original files in your Cloud Drive and create a compressed copy with digital watermark and ID. This copy will be stored on our server and fully available on our platform, shareable for non-commercial use with no restrictions. We’ll use the compressed file to promote your work. However, you will always have full control over it.
            </p>
            <a href="{{ route('profile.dropbox') }}" class="btn btn-primary dropbox">Connect to your Dropbox</a>
          </div>      
        </modal-container>
    </profile-modal>
@endsection