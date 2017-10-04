@extends('layouts.layout')

@section('content')
@include('layouts.notification')
<?php 
use App\Http\Controllers\ReviewsController; 
use App\Http\Controllers\UserController;
?>

@if(Auth::user()->role == 'non-student')

<section class="sotlLogin">
        <div class="container-fluid">
            <div class="logForm">
                <h1 class="registerHead">Profile Page</h1>

                <form action="/profile/update" method="POST">
                	{{ csrf_field() }}
                  <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{$user->name}}">
                  </div>
                  <div class="form-group">
                    <label for="body">email</label>
                    <input class="form-control" id="email" name="email" value="{{$user->email}}">
                  </div>
                  <div class="form-group">
                        <label for="body">Institution</label>
                        <input type="text" value="{{$user->institution}}" id="institution" name="institution" placeholder="Institution Name">
                  </div>  
     
                 <!--  <div class="form-group">
                    <label for="body">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password"> 
                  </div>
                  <div class="form-group">
                    <label for="body">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                  </div>
                   -->
                  <button type="submit" class="s-mit btn btn-primary">Update</button>
                </form>
            </div>
        </div>
</section>      

@else
  <!-- section -->
  <div class="alert alert-success notification2 hide" style="position: fixed; top: 0; right: 0;">
    
  </div>
    <section class="sotlProfile">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="outlineBox">
                        <h3>Student Personal Details</h3>
                        <div class="personalDetailsInner">
                          <form method="POST" action="/profile/update">  
                          {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-5"><h5>Student Name :</h5></div>
                                <div class="col-sm-7 w100"><input type="text" id="name" name="name" value="{{$user->name}}" placeholder="Name"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5"><h5>INSTITUTION :</h5></div>
                                <div class="col-sm-7 w100"><input type="text" value="{{$user->institution}}" id="institution" name="institution" placeholder="Institution Name"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5"><h5>COURSE ENROLLMENT :</h5></div>
                                <div class="col-sm-7 w100"><input type="text" id="course" name="course" value="{{$user->course}}" placeholder="Course Name"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5"><h5>STUDENT ID :</h5></div>
                                <div class="col-sm-7 w100"><input type="text" id="id" name="id" disabled value="{{$user->id}}" placeholder="Student ID"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5"><h5>EMAIL ADDRESS :</h5></div>
                                <div class="col-sm-7 w100"><input type="text" id="email" name="email" placeholder="name@email.com" value="{{$user->email}}"></div>
                            </div>
                            <div class="row ">
                              <div class="col-sm-12">
                              <div class="text-right">
                                  <button type="submit" class="s-mit">Update</button>
                              </div>
                                
                              </div>
                            </div>
                          </form>  
                        </div>
                    </div>
                    
                    <div class="outlineBox outlineBox2">
                        <h3>Student Challenge Progress</h3>
                        <div class="personalDetailsInner studentChallenge">
                        <!-- To manage the current users challenges -->
                        <?php 
                            $user = new UserController;
                            $challenges = $user->getUpdatedChallenges();
                        ?>
                            <div class="row">
                                <div class="col-sm-5"><h5>Challenge 1 :</h5></div>
                                <div class="col-sm-7">
                                    <div class="f-controls">
                                        <div class="c-chkbox">
                                            <div class="chkbox">
                                                <input id="checkValue1" class="checkValue" type="hidden" name="Challenge1" value="c1">
                                                <input class="selected checkboxselect" {{$challenges['checked1']}} id="checkboxselect" type="checkbox" name="showlet">

                                                <label for="letProperties" id="checkboxselect">Done</label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="" style="clear:both"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5"><h5>Challenge 2 :</h5></div>
                                <div class="col-sm-7">
                                    <div class="f-controls">
                                        <div class="c-chkbox">
                                            <div class="chkbox">
                                                 <input id="checkValue2" class="checkValue" type="hidden" name="Challenge2" value="c2">
                                                <input class="selected checkboxselect" {{$challenges['checked2']}} id="checkboxselect" type="checkbox" name="showlet">
                                                <label for="letProperties" id="checkboxselect">Available</label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5"><h5>Challenge 3 :</h5></div>
                                <div class="col-sm-7">
                                    <div class="f-controls">
                                        <div class="c-chkbox">
                                            <div class="chkbox">
                                                <input id="checkValue3" class="checkValue" type="hidden" name="Challenge3" value="c3">
                                                <input class="selected checkboxselect" {{$challenges['checked3']}} id="checkboxselect" type="checkbox" name="showlet">
                                                <label for="letProperties" id="checkboxselect">Available</label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Review Controller to get current user heat score -->
                    <?php 
                        $info = new ReviewsController;
                        $heatScores = $info->getUserHeatScore();
                    ?>
                    
                    <div class="outlineBox outlineBox2">
                        <h3>STUDENT’S HEAT SCORE</h3>
                        <div class="personalDetailsInner studentChallenge">
                            <div class="row">
                                <div class="col-sm-6 col-xs-8"><h5>Direction :</h5></div>
                                <div class="col-sm-6 col-xs-4">
                                    <div class="heatScore"><i class="fa fa-star"></i><span>{{number_format($heatScores['directorHeatScore'], 1)}}</span></div>
                                </div>
                                <div class="" style="clear:both"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-8"><h5>Writing :</h5></div>
                                <div class="col-sm-6 col-xs-4">
                                    <div class="heatScore"><i class="fa fa-star"></i><span>{{number_format($heatScores['writerHeatScore'], 1)}}</span></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-8"><h5>Acting :</h5></div>
                                <div class="col-sm-6 col-xs-4">
                                    <div class="heatScore"><i class="fa fa-star"></i><span>{{number_format($heatScores['actorHeatScore'], 1)}}</span></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-8"><h5>CINEMATOGRAPHY :</h5></div>
                                <div class="col-sm-6 col-xs-4">
                                    <div class="heatScore"><i class="fa fa-star"></i><span>{{number_format($heatScores['cinematographyHeatScore'], 1)}}</span></div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6 col-xs-8"><h5>EDITING :</h5></div>
                                <div class="col-sm-6 col-xs-4">
                                    <div class="heatScore"><i class="fa fa-star"></i><span>{{number_format($heatScores['editorHeatScore'], 1)}}</span></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-8"><h5>PRODUCER :</h5></div>
                                <div class="col-sm-6 col-xs-4">
                                    <div class="heatScore"><i class="fa fa-star"></i><span>{{number_format($heatScores['producerHeatScore'], 1)}}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
                <!--First Column Ends Here-->
                
                <div class="col-md-6">
                    <div class="outlineBox outBox3">
                        <h3>Student Course Progress</h3>
                        <div class="personalDetailsInner">
                            <div class="row">
                                <div class="col-sm-4"><h5>Lesson 1 :</h5></div>
                                <div class="col-sm-8 w100"><div id="jq"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><h5>Lesson 2 :</h5></div>
                                <div class="col-sm-8 w100"><div id="jq1"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><h5>Lesson 3 :</h5></div>
                                <div class="col-sm-8 w100"><div id="jq2"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><h5>Lesson 4 :</h5></div>
                                <div class="col-sm-8 w100"><div id="jq3"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><h5>Lesson 5 :</h5></div>
                                <div class="col-sm-8 w100"><div id="jq4"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><h5>Lesson 6 :</h5></div>
                                <div class="col-sm-8 w100"><div id="jq5"></div></div>
                            </div>
                        </div>
                    </div>
                    <!-- To calculate the student fame score of the current user -->
                    <?php 
                        $famescore = $user->getFameScore();
                    ?>
                    
                    <div class="outlineBox outlineBox2">
                        <h3>Student's Fame Score</h3>
                        <div class="personalDetailsInner studentChallenge">
                            <div class="row">
                                <div class="col-md-7 col-xs-9"><h5>TOTAL FAME :</h5></div>
                                <div class="col-sm-5 col-xs-3"><h5>{{number_format($famescore['totalFame'])}}</h5></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7 col-xs-9"><h5>REVIEWS WRITTEN :</h5></div>
                                <div class="col-sm-5 col-xs-3"><h5>{{$famescore['totalReview']}}</h5></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7 col-xs-9"><h5>REVIEWS RATED HELPFUL :</h5></div>
                                <div class="col-sm-5 col-xs-3"><h5>{{$famescore['totalHelpful']}}</h5></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
<script type="text/javascript">
    setTimeout(function() {
        $('.alert-success.notification2').fadeOut('fast');
    }, 7000);
    jQuery(document).ready( function(){
        jQuery(".checkboxselect").click( function(){
            var challenge = jQuery(this).siblings('.checkValue').val();
            if(jQuery(this).is(':checked')){
             var enable = 1;
             jQuery(".notification2").css('display','block'); 
            }
            else{
             var enable = 0;
             jQuery(".notification2").css('display','block');  
            }
            jQuery.ajax({
                url: "/user/update/challenge",
                type: "GET",
                data:{'challenge' : challenge, 'enable' : enable},
                success: function(data){
                     console.log(data);
                }    
            });
        });
    });

</script>
   
@endif



@endsection('content')