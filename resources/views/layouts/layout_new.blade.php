<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>SOTL Theater</title>
      <link rel="icon" href="/img/favicon.png" sizes="32x32">
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"  ></script>
    <script type="text/javascript" src="/js/custom.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="/css/custom.css">
  </head>

  <body class="whitel">

  <!-- @include("layouts.header2") -->

        @yield("content")

  </body>

  

  
</html>
