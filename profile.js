
$(function(){
    // Ajax call to updateusername.php
  $("#updateusernameform").submit(function(event){
      event.preventDefault();
      var dataToPost = $(this).serializeArray();
      //console.log(dataToPost);
      $.ajax({
          url: 'updateusername.php',
          type: "POST",
          data: dataToPost,
          success: function(data){
              if(data == 'error'){
                  $("#updateusernamemessage").html("<div class='alert alert-danger'>There was an error.Username was not updated.Please try again later!</div>");
              }else {
                  // $("#updateusernamemessage").html("<div class='alert alert-success'>Username was updated successfully!</div>")
                 // location.reload();
              }
          },
          error: function(){
              $("#updateusernamemessage").html("<div class='alert alert-danger'>There was an error with the ajax call.Please try again later!</div>");
          }

      })

  })





//Ajax call to updatepassword.php
    $("#updatepasswordform").submit(function(event){
        event.preventDefault();
        var dataToPost = $(this).serializeArray();
        //console.log(dataToPost);
        $.ajax({
            url: 'updatepassword.php',
            type: "POST",
            data: dataToPost,
            success: function(data){
                if(data) {
                    $("#updatepasswordmessage").html(data);
                }
            },
            error: function(){
                $("#updatepasswordmessage").html("<div class='alert alert-danger'>There was an error with the ajax call.Please try again later!</div>");
            }

        })

    })





//Ajax call to updateemail.php



});
