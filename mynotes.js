// we are wrapping all code in a function that secures that everything we are doing is after the page loads
$(function(){
    //define variables
    //load notes on page load:Ajax call to loadnotes.php

    $.ajax({
      url:'loadnotes.php',
      success:function(data){
          $("#notes").html(data);
      }

    });


    //add a new note:Ajax call to createnote.php
    //type notes:Ajax call to updatenote.php
    //click on all notes button
    //click on done button after editing: load notes again
    //click on edit:go to edit mode(show delete buttons,....)

    //functions
       //click on  note
       //click on delete button
       //show Hide function


});