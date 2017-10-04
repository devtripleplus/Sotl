    <!-- header -->
 <header class="hdr-bg">        
        <div class="l0go1"><a href="/"><img src="/img/logo.png" alt=""></a></div>
        <div class="menu">
            <ul class="nav navbar-nav">
               
                
                @if(!auth()->check())
                        
                        <li><a href="/"><span class="glyphicon"></span>Theater</a></li>
                        <li><a href="/"><span class="glyphicon"></span>About <span class="caret"></span></a>
                                <ul>
                                    <li><a href="/">Menu</a></li>
                                    <li><a href="/">Menu</a></li>
                                    <li><a href="">Menu</a></li>
                                    <li><a href="">Menu</a></li>
                                </ul>
                        </li>
                     <li><a href="/"><span class="glyphicon"></span>Contact</a></li>
                     <li><a href="http://localhost/sotl/wp/"><span class="glyphicon"></span>Back To School</a></li>
                @endif

            </ul> 
        </div>
    </header>
 
