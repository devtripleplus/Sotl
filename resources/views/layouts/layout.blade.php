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
    <script src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/addfield.js"></script>
    <script type="text/javascript" src="/js/custom.js"></script>
    <script type="text/javascript" src="/js/rangeslider.min.js"></script>
    <script type="text/javascript" src="/js/rangeslider.js"></script>
    <script type="text/javascript" src="/js/star-rating.js"></script>
    <script type="text/javascript" src="/js/custom-file-input.js"></script>
    <script type="text/javascript" src="/js/jquery.custom-file-input.js"></script>

  <!-- CDN for autocomplete -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"><!-- 
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- CDN for autocomplete -->
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="/css/blog.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/owl.carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="/css/hover.css">
    <link rel="stylesheet" href="/css/controls.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/star-rating.css">
    <link rel="stylesheet" href="/css/jquery.lineProgressbar.css">
<!-- CDN for spinner -->
    <script src="https://d3js.org/d3.v4.min.js"></script>
<!-- CDN for spinner -->
  </head>

  <body class="whitel">

  @include("layouts.header")
  <!-- <div class="maincontent"> -->
    @include("layouts.error")

    <!-- <div class="container"> -->

      <!-- <div class="row"> -->

        <!-- <div class="col-sm-12 blog-main"> -->

          @yield("content")

        <!-- </div> --><!-- /.blog-main -->

        {{--@include("layouts.sidebar")--}}

      <!-- </div> --><!-- /.row -->

    <!-- </div> --><!-- /.container -->
      

    <!-- </div> -->
   

  @include("layouts.footer")

  </body>


<script type="text/JavaScript">
    var rangeSlider = function(){
  var slider = $('.range-slider'),
      range = $('.range-slider__range'),
      value = $('.range-slider__value');
    
  slider.each(function(){

    value.each(function(){
      var value = $(this).prev().attr('value');
      $(this).html(value);
    });

    range.on('input', function(){
      $(this).next(value).html(this.value);
    });
  });
};

rangeSlider();
function countChar(val) {
        var len = val.value.length;
        if (len >= 500) {
          val.value = val.value.substring(0, 500);
        } else {
          $('#charNum').text(len + ' CHARACTER');
        }
      };
    
</script>  

  
</html>
