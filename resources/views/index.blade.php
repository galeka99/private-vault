<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="google-signin-client_id"
    content="741909550840-d3j8u1aro5dpr9ivlh7mjtt4r5lsfhd2.apps.googleusercontent.com">
  <title>Selamat Datang - Private Vault</title>
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>

<body class="bg-blue-100">
  <div class="container mx-auto p-3 flex flex-col justify-center items-center min-h-screen">
    <img src="{{ asset('img/unlock.svg') }}" alt="private vault illustration" class="w-1/2 max-w-sm mb-5">
    <span class="text-5xl font-bold mb-4 text-blue-800">Private Vault</span>
    <span class="text-center mb-4">Hilangkanlah kebiasaan mengingat kata sandi dan cobalah untuk menyimpannya menjadi
      satu</span>
    <button id="signin_btn"
      class="group bg-blue-500 hover:bg-blue-600 hover:shadow-md text-white rounded-full shadow flex flex-row items-center"
      data-onsuccess="postSignIn">
      <div class="bg-white group-hover:bg-gray-100 rounded-l-full p-3">
        <img src="{{ asset('img/google.svg') }}" alt="google icon" width="25" height="25">
      </div>
      <span class="px-4">Masuk dengan Google</span>
    </button>
  </div>
  <script>
    function postSignIn(user) {
      const form = document.createElement('form');
      const token = user.getAuthResponse().id_token;
      const profile = user.getBasicProfile();
      const id = profile.getId();
      const name = profile.getName();
      const avatar = profile.getImageUrl();
      const email = profile.getEmail();

      form.setAttribute('method', 'POST');
      form.setAttribute('action', '{{ url('/login') }}');
      form.innerHTML += `<input type="hidden" name="id" value="${id}">`;
      form.innerHTML += `<input type="hidden" name="name" value="${name}">`;
      form.innerHTML += `<input type="hidden" name="image_url" value="${avatar}">`;
      form.innerHTML += `<input type="hidden" name="email" value="${email}">`;
      form.innerHTML += `<input type="hidden" name="token" value="${token}">`;
      form.innerHTML += `<input type="hidden" name="_token" value="{{ csrf_token() }}">`;
      document.body.appendChild(form);
      form.submit();
    }

    window.addEventListener('DOMContentLoaded', () => {
      gapi.load('auth2', function() {
        auth2 = gapi.auth2.init({
          client_id: '741909550840-d3j8u1aro5dpr9ivlh7mjtt4r5lsfhd2.apps.googleusercontent.com',
          cookiepolicy: 'single_host_origin',
        });
        const signinButton = document.querySelector('button#signin_btn');
        auth2.attachClickHandler(signinButton, {},
          postSignIn,
          function(error) {
            console.log('Error: ', error.error);
          });
      });
    });
  </script>
</body>

</html>
