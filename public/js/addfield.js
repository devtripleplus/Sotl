  //Add More director Fields
  $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_director"); //Fields wrapper
    var add_button      = $(".add_field_director"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).find("div").append('<p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a><input type="text" class="crew" placeholder="Student Name" name="director[]"/><input type="text" class="crewid" hidden name="directorid[]"/></p>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('p').remove(); x--;
    })
});

  //Add More Producer Fields
  $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_producer"); //Fields wrapper
    var add_button      = $(".add_field_producer"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).find("div").append('<p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a><input type="text" class="crew" placeholder="Student Name" name="producer[]"/><input type="text" class="crewid" hidden name="producerid[]"/></p>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('p').remove(); x--;
    })
});

    //Add More editor Fields
  $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_editor"); //Fields wrapper
    var add_button      = $(".add_field_editor"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).find("div").append('<p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a><input type="text" class="crew" placeholder="Student Name" name="editor[]"/><input type="text" class="crewid" hidden name="editorid[]"/></p>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('p').remove(); x--;
    })
});

    //Add More writer Fields
  $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_writer"); //Fields wrapper
    var add_button      = $(".add_field_writer"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).find("div").append('<p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a><input type="text" class="crew" placeholder="Student Name" name="writer[]"/><input type="text" class="crewid" hidden name="writerid[]"/></p>'); //add input box
        }
        
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('p').remove(); x--;
    })
});

    //Add More cinemotography Fields
  $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_cinemotography"); //Fields wrapper
    var add_button      = $(".add_field_cinemotography"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).find("div").append('<p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a><input type="text" class="crew" placeholder="Student Name" name="cinemotography[]"/><input type="text" class="crewid" hidden name="cinemotographyid[]"/></p>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('p').remove(); x--;
    })
});

    //Add More actor Fields
  $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_actor"); //Fields wrapper
    var add_button      = $(".add_field_actor"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).find("div").append('<p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a><input type="text" class="crew" placeholder="Student Name" name="actor[]"/><input type="text" class="crewid" hidden name="actorid[]"/></p>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('p').remove(); x--;
    })
});

