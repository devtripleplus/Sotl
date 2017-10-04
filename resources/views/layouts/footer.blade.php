<!-- footer -->
<?php 
 use Illuminate\Support\Facades\Route;
    $currentPath = Route::getFacadeRoot()->current()->uri(); 
/*if($currentPath == '/' || $currentPath == 'theater'){ ?>
    <footer>
        <div class="container">
            <div class="row">
                
                <div class="col-sm-3">
                    <div class="fCols">
                        <div class="fLogo">
                            <img src="/img/logo.png" alt="">
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="fCols">
                        
                        <div class="fColsUl">
                            <ul>
                                <li><a href="">BROWSE CLASSES</a></li>
                                <li><a href="">HELP CENTER</a></li>
                                <li><a href="">CONTACT US</a></li>
                            </ul>
                            
                            <ul>
                                <li><a href="">PRIVACY</a></li>
                                <li><a href="">TERMS</a></li>
                                <li><a href="">CARRER</a></li>
                            </ul>
                            
                            <p>Copyright &copy; 2017 SOTL</p>
                            
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-3">
                     <div class="fCols">
                         <div class="fSsl">
                             <img src="/img/fSsl.png" alt="">
                         </div>
                     </div>
                </div>
                
            </div>
        </div>
    </footer>

  <?php }*/ ?>
  

<script src="/css/owl.carousel/owl.carousel.min.js"></script>
<script src="/js/custom.js"></script>
<script type="text/javascript" src="/js/jquery.lineProgressbar.js"></script>
<script>

    setTimeout(function() {
        $('.alert-success').fadeOut('fast');
    }, 7000);
    $(function(){
    $('#owl-carousel4-img').owlCarousel({
    loop:true,
    stagePadding: 80,
    margin:25,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
}) 
$('#owl-carousel4-img2').owlCarousel({
    loop:true,
    margin:30,
    nav:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
}) 
    
    });
     $('.f-slide').owlCarousel({
    stagePadding: 100,
    loop:true,
    margin:30,
    nav:true,
    autoplay:true,
    autoplaySpeed:1000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
})
$(window).load(function(){
    $('.add-more1').click(function(){
         $('.direc1').toggle('esaeIn');
         $(this).find('i').toggle('fa-minus fa-plus');
   });
        $('.add-more2').click(function(){
         $('.pro1').toggle('esaeIn');
         $(this).find('i').toggle('fa-minus fa-plus');
   });
        $('.add-more3').click(function(){
         $('.edi1').toggle('esaeIn');
         $(this).find('i').toggle('fa-minus fa-plus');
   });
        $('.add-more4').click(function(){
         $('.wri1').toggle('esaeIn');
         $(this).find('i').toggle('fa-minus fa-plus');
   });
        $('.add-more5').click(function(){
         $('.cine1').toggle('esaeIn');
         $(this).find('i').toggle('fa-minus fa-plus');
   });
        $('.add-more6').click(function(){
         $('.act1').toggle('esaeIn');
         $(this).find('i').toggle('fa-minus fa-plus');
   });
})
</script>

<script type="text/javascript">
    jQuery('#jq').LineProgressbar({
      percentage: 50,
      fillBackgroundColor: '#3498db',
      backgroundColor: '#fff',
      radius: '0px',
      height: '30px',
      width: '100%'
    });
    
    jQuery('#jq1').LineProgressbar({
      percentage: 72,
      fillBackgroundColor: '#f7c25f',
      backgroundColor: '#fff',
      radius: '0px',
      height: '30px',
      width: '100%'
    });
    
    jQuery('#jq2').LineProgressbar({
      percentage: 35,
      fillBackgroundColor: '#3498db',
      backgroundColor: '#fff',
      radius: '0px',
      height: '30px',
      width: '100%'
    });
    
    jQuery('#jq3').LineProgressbar({
      percentage: 60,
      fillBackgroundColor: '#f7c25f',
      backgroundColor: '#fff',
      radius: '0px',
      height: '30px',
      width: '100%'
    });

    jQuery('#jq4').LineProgressbar({
      percentage: 80,
      fillBackgroundColor: '#3498db',
      backgroundColor: '#fff',
      radius: '0px',
      height: '30px',
      width: '100%'
    });
    
    jQuery('#jq5').LineProgressbar({
      percentage: 20,
      fillBackgroundColor: '#f7c25f',
      backgroundColor: '#fff',
      radius: '0px',
      height: '30px',
      width: '100%'
    });

    

    
</script>