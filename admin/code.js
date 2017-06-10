var total=0.00;

window.onload = function(){
    $("#total").html("NGN " + total);   
}

function update_customer(u,customer){
    if(u === 'basicinfo'){
      
         if($("#firstname").val()==="" && ($("#middlename").val()==="" || $("#lastname").val()==="")){
            //make them show error
            $("#fn").addClass('has-error');
            $("#mn").addClass('has-error');
            $("#ln").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();
        }
        else if(!isNaN($("#firstname").val()) || !isNaN($("#middlename").val()) || !isNaN($("#lastname").val())){
            $("#fn").addClass('has-error');
            $("#mn").addClass('has-error');
            $("#ln").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if(($("#firstname").val()).length < 2){
            $("#fn").addClass('has-error');                        
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if(($("#lastname").val()).length < 2){           
            $("#ln").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if($("#phone1").val() === "" && $("#phone2").val() === ""){
            $("#p1").addClass('has-error');
            $("#p2").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show(); 
        }
        else if(isNaN($("#phone1").val()) || isNaN($("#phone2").val())){
            $("#p1").addClass('has-error');
            $("#p2").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }        
        else {
            
            $("#fn").removeClass('has-error');
            $("#mn").removeClass('has-error');
            $("#ln").removeClass('has-error');
            $("#p1").removeClass('has-error');
            $("#p2").removeClass('has-error'); 
            $("#validator").hide();
            
            $.ajax({
                type: "POST",
                url: "update_basic.php?id="+customer,
                data: $('#basic').serialize(),
                success: function (msg) {

                alert(msg);

                },
                error: function (error) {
                   alert(error);
                }
            });
    }
    }

    else if(u==='nok'){
        
        if($("#nfirstname").val()==="" || $("#surname").val()===""){
            //make them show error
            $("#nfn").addClass('has-error');
            $("#nsn").addClass('has-error');                
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();
        }
        else if(!isNaN($("#nfirstname").val()) || !isNaN($("#surname").val())){
            $("#nfn").addClass('has-error');
            $("#nsn").addClass('has-error');      
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if(($("#nfirstname").val()).length < 2){           
            $("#nfn").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if(($("#surname").val()).length < 2){           
            $("#nsn").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if($("#nphone1").val() === "" && $("#nphone2").val() === ""){
            $("#np1").addClass('has-error');
            $("#np2").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show(); 
        }
        else if(isNaN($("#nphone1").val()) || isNaN($("#nphone2").val())){
            $("#np1").addClass('has-error');
            $("#np2").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }        
        else{
             $("#nfn").removeClass('has-error');
             $("#nsn").removeClass('has-error');
             $("#np1").removeClass('has-error');
             $("#np2").removeClass('has-error');
             $("#validator").hide();
             
            $.ajax({
                type: "POST",
                url: "update_nok.php?id="+customer,
                data: $('#nok').serialize(),
                success: function (msg) {

                alert(msg);

                },
                error: function (error) {
                   alert(error);
                }
            });
        }
    }
    else if(u==='payment'){
        $.ajax({
            type: "POST",
            url: "update_payment.php?id="+customer,
            data: $('#payment').serialize(),
            success: function (msg) {

            alert(msg);

            },
            error: function (error) {
               alert(error);
            }
        });
    }
}

function save(n){   
             
    if (n === 'basicinfo') {
         if($("#firstname").val()==="" && ($("#middlename").val()==="" || $("#lastname").val()==="")){
            //make them show error
            $("#fn").addClass('has-error');
            $("#mn").addClass('has-error');
            $("#ln").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();
        }
        else if(!isNaN($("#firstname").val()) || !isNaN($("#middlename").val()) || !isNaN($("#lastname").val())){
            $("#fn").addClass('has-error');
            $("#mn").addClass('has-error');
            $("#ln").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if(($("#firstname").val()).length < 2){
            $("#fn").addClass('has-error');                        
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if(($("#lastname").val()).length < 2){           
            $("#ln").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if($("#phone1").val() === "" && $("#phone2").val() === ""){
            $("#p1").addClass('has-error');
            $("#p2").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show(); 
        }
        else if(isNaN($("#phone1").val()) || isNaN($("#phone2").val())){
            $("#p1").addClass('has-error');
            $("#p2").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }        
        else {
            
            $("#fn").removeClass('has-error');
            $("#mn").removeClass('has-error');
            $("#ln").removeClass('has-error');
            $("#p1").removeClass('has-error');
            $("#p2").removeClass('has-error'); 
            $("#validator").hide();
            
                $.ajax({
                    type: "POST",
                    url: "save_basic.php",
                    data: $('#basic').serialize(),
                    success: function (msg) {

                        if (msg === "not") {
                            $("#generalinfo").addClass('alert-danger');
                            $("#generalinfo").html("Oops... something went wrong, please try again");
                        }                
                        else {
                            $("#generalinfo").addClass('text-success');
                            $("div#bar").css("width", "20%");
                            $("#progresslevel").html('20%');
                            $("#generalinfo").html("Customer with ID " + msg + " has been created");
                        }

                    },
                    error: function (error) {
                        $("#generalinfo").html(error);

                    }
                });
        }
    }
    else if (n === 'nok') {
        
        if($("#firstname").val()==="" || $("#surname").val()===""){
            //make them show error
            $("#nfn").addClass('has-error');
            $("#nsn").addClass('has-error');                
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();
        }
        else if(!isNaN($("#firstname").val()) || !isNaN($("#surname").val())){
            $("#nfn").addClass('has-error');
            $("#nsn").addClass('has-error');      
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if(($("#firstname").val()).length < 2){           
            $("#nfn").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if(($("#surname").val()).length < 2){           
            $("#nsn").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }
        else if($("#nphone1").val() === "" && $("#nphone2").val() === ""){
            $("#np1").addClass('has-error');
            $("#np2").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show(); 
        }
        else if(isNaN($("#nphone1").val()) || isNaN($("#nphone2").val())){
            $("#np1").addClass('has-error');
            $("#np2").addClass('has-error');            
            $("#validator").html("There is an error in your input");
            $("#validator").addClass("text-danger");
            $("#validator").show();  
        }        
        else{
             $("#nfn").removeClass('has-error');
             $("#nsn").removeClass('has-error');
             $("#np1").removeClass('has-error');
             $("#np2").removeClass('has-error');
             $("#validator").hide();
        
                $.ajax({
                    type: "POST",
                    url: "save_nok.php",
                    data: $('#nok').serialize(),
                    success: function (msg) {
                        if (msg === "not") {
                            $("#generalinfo").addClass('alert-danger');
                            $("#generalinfo").html("Oops... something went wrong, please try again");
                        }
                        else {
                            $("#generalinfo").addClass('text-success');
                            $("div#bar").css("width", "40%");
                            $("#progresslevel").html('40%');
                            $("#generalinfo").html("NOK of Customer with ID " + msg + " has been saved");
                        }


                    },
                    error: function (error) {
                        $("#generalinfo").html(error);

                    }
                });
            }
    }
    else if (n === 'payment') {
        $.ajax({
            type: "POST",
            url: "save_payment.php",
            data: $('#payment').serialize(),
            success: function (msg) {
                if (msg === "not") {
                    $("#generalinfo").addClass('alert-danger');
                    $("#generalinfo").html("Oops... something went wrong, please try again");
                }
                else {
                    $("#generalinfo").addClass('text-success');
                    $("div#bar").css("width", "100%");
                    $("#progresslevel").html('100%');
                    $("#generalinfo").html("Payment and Subscription of Customer with ID " + msg + " has been saved. Customer creation complete. Please reset the form before attempting to register another customer");
                }

            },
            error: function (error) {
                $("#generalinfo").html(error);

            }
        });
    }

}

function confirm(value,id){
  s = "#confirm_" + id;
    $(s).html(value);
}

function discounts(value,id){
  s = "#confirm_" + id;
    $(s).html(value);
//    display_total(-value);
}

//function confirm_check(value,id){
//
//}
function display_price(id,price,level){
    p = "#confirm_" + id;
    //check if its on
    if(level === 'on'){
        $(p).html(price);
//        display_total(price);
    }
    $("#tracker_2").val('0.00');
   
}  

function downvalue(id,price){

if($('#tracker_input').val() !== ""){
//    display_total(-$('#tracker_input').val());
//    $('#tracker_input').val(0);
}
    p = "#confirm_" + id;
    $(p).html(price);
    $("#tracker_2").val(price);
    $("#renewal").prop('checked', false);
//    display_total(price);
    
}

function downvalue_2(id,duration){

    p = "#confirm_" + id;
    $(p).html(duration);
    $("#duration").val(duration);
  
    
}
function add_service(price,name,input,id,this_id){
    //add name and price to the confirm to the confirm,
   //change input value to price
   q = "#confirm_" + id;
   if(document.getElementById(this_id).checked){
        $(q).append("<span class="+this_id + price+">" + name + " : " + price + ", </span>"); 
        $(input).val(price);
   }
   else if(!((document.getElementById(this_id)).checked)){
       
       var re = "."+this_id+price;               
       $(re).html('');
       $(input).val(0.00);
       
   }
   //check if the box is selected
//   if($(q).checked){
//       $(q).append("<br>" + name + " : " + price + ","); 
//       $(input).val(price);
//   }
//  alert('check!');
}

function get_total(){
     
   
    //get all selected value
    
    var tracker = $("#tracker_2").val();
    var duration = $("#duration").val();
    var service1 = $("#service_input_0").val();
    var service2 = $("#service_input_1").val();
    var service3 = $("#service_input_2").val();
    var service4 = $("#service_input_3").val();
    var service5 = $("#service_input_4").val();
    var paid = parseFloat($('#amount_paid').val());
    var discount = parseFloat($('#discount').val());
    var expected = 0;
    
    tracker = parseFloat(tracker);
    duration = parseFloat(duration);
    service1 = parseFloat(service1);
    service2 = parseFloat(service2);
    service3 = parseFloat(service3);
    service4 = parseFloat(service4);
    service5 = parseFloat(service5);    
 
    expected = tracker + service1 + service2 + service3 + service4 + service5;
    
    var expected_in_time = expected * duration;
    
    var expect = expected_in_time - discount;  

   $("#total").html("NGN " + expect);
   
   expect = parseFloat(expect);
   
//   alert(tracker); alert(duration); alert(service1); alert(service2); alert(service3); alert(service4); alert(service5); alert(expected); alert(expect);
   
        if(paid < expect){
           $("#total").removeClass('text-warning');
           $("#total").removeClass('text-success');
           $("#total").addClass('text-danger');
           $('#tell').html('Amount paid is less than amount required, registration will be incomplete');
           $('#tell').addClass('text-info');
        }
        else if(paid > expect){
           $("#total").removeClass('text-danger');
           $("#total").removeClass('text-success');
           $("#total").addClass('text-warning');
           $('#tell').html('Unbalanced! Registration will be complete if you submit, please check again for errors');
        }
        else if(paid === expect){
           $("#total").removeClass('text-danger');
           $("#total").removeClass('text-warning');
           $("#total").addClass('text-success');
           $('#tell').html('Balanced!');
        }
}


    
    