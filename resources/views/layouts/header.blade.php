    <!-- header -->
<?php 
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\SiteSettingsController;
    use App\Http\Controllers\FilmsController;
    $currentPath = Route::getFacadeRoot()->current()->uri(); 
    $filmss = new FilmsController;
    $class = '';
    if(Auth::user()){
        $class = 'active';
    }

    $sitesettings = new SiteSettingsController;
    $settings = $sitesettings->getSettingsData();
?>
    <header class="hdr-bg">        
        <div class="l0go1 {{$class}}"><a href="/"><img src="/img/logo.png" alt=""></a></div>
        <div class="menu">
            <ul class="nav navbar-nav">
               
                
                @if(!auth()->check())
                        <!--  @if($currentPath == 'videos/{vimeo_id}' && session('curr_film_id'))
                             @if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'screening') 
                             @endif
                             <li><a href="/videos/{{session('curr_film_id')}}/?view=screening"><span class="glyphicon"></span>Screening</a></li>
                        @endif -->
                        
                        <li><a href="/"><span class="glyphicon"></span>Theater</a></li>
                        <li><a href="{{$settings['wp_url']}}/about-2/"><span class="glyphicon"></span>About <span class="caret"></span></a>
                        
                                <ul>
                                    <li><a href="{{$settings['wp_url']}}/friendly-asked-questions/">Frequently Asked Questions</a></li>
                                    <li><a href="{{$settings['wp_url']}}/events/list/">Events</a></li>
                                </ul>
                        </li>
                        <li><a href="{{$settings['wp_url']}}/contact/"><span class="glyphicon"></span>Contact</a></li>
                        
                        <li><a href="{{$settings['wp_url']}}/wp-login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        <li><a href="{{$settings['wp_url']}}/wp-login.php?action=register"><span class="glyphicon glyphicon-user"></span>Register</a></li>
                    
                @else
                    @if($currentPath != '/')
                        
                    @endif
                     
                    
                    
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'student')
                        <li><a href="{{$settings['wp_url']}}/features/"><span class="glyphicon"></span>Tools <span class="caret"></span></a>
                                <ul>
                                    <li><a href="{{$settings['wp_url']}}/asset-repository/#video-assets-tab">Stock Footage</a></li>
                                    <li><a href="{{$settings['wp_url']}}/asset-repository/#music-assets-tab">Music</a></li>
                                    <li><a href="{{$settings['wp_url']}}/asset-repository/#sfx-assets-tab">Sound Effects</a></li>
                                </ul>
                        </li>
                        <li><a href="/"><span class="glyphicon"></span>Theater</a></li>
                        
                       <!--  @if($currentPath == 'videos/{vimeo_id}' && session('curr_film_id'))
                             @if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'screening') 
                             @endif
                            <li><a href="/videos/{{session('curr_film_id')}}/?view=screening"><span class="glyphicon"></span>Screening</a></li>
                        @else
                            <li><a href="/upload"><span class="glyphicon"></span>Screening</a></li>
                        @endif -->
                        <li><a href="/upload"><span class="glyphicon"></span>Screening</a></li>
                        

                        <!-- <li><a href="/upload"><span class="glyphicon"></span>Upload Films</a></li> -->
                        @elseif(Auth::user()->role == 'admin' || Auth::user()->role == 'fans')
                        <li><a href="/"><span class="glyphicon"></span>Theater</a></li>

                    @else
                        <li><a href="/home/"><span class="glyphicon"></span>Home</a></li> 
                    @endif
                    <!--  <li><a href="/profile"><span class="glyphicon"></span>Profile</a></li> -->
                     <li><a href="{{$settings['wp_url']}}/about-2/"><span class="glyphicon"></span>About <span class="caret"></span></a>
                                <ul>
                                    <li><a href="{{$settings['wp_url']}}/friendly-asked-questions/">Frequently Asked Questions</a></li>
                                    <li><a href="{{$settings['wp_url']}}/events/list/">Events</a></li>
                                </ul>
                     </li>

                     <li><a href="{{$settings['wp_url']}}/contact/"><span class="glyphicon"></span>Contact</a></li>
	        	     <li><a href="{{$settings['wp_url']}}/"><span class="glyphicon"></span>Back To School</a></li>
                @endif

            </ul> 
        </div>
    </header>
 
