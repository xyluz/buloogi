

function delete_admin(n){ 
   
                     var confirm_delete = confirm('Are you sure?');
                           if(confirm_delete === true){                                
                        $.ajax({
                                type: "POST",
                                url: "admin_delete.php?id=" + n,
                                data: $('#ad_id').serialize(),
                                success: function(msg){
                                   
                                      alert(msg);
//                                      window.location.reload();

                                },
                                error: function(error){
                                        alert('not done, something went wrong');

                                        }
                                });
                            }
                            else{
                                alert('delete cancelled!');
                            }
                        }