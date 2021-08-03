<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="google-signin-client_id"
    content="741909550840-d3j8u1aro5dpr9ivlh7mjtt4r5lsfhd2.apps.googleusercontent.com">
  <title>@yield('title') - Private Vault</title>
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>

<body>
  <main>
    <div class="container p-3 mx-auto">
      @yield('content')
    </div>
  </main>
  @include('components.alert')
</body>

</html>
