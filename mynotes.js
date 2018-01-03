// we are wrapping all code in a function that secures that everything we are doing is after the page loads
$(function(){
    //define variables
    var activeNote = 0;
    var editMode = false;
    //load notes on page load:Ajax call to loadnotes.php

    $.ajax({
      url:'loadnotes.php',
      success:function(data){
          $("#notes").html(data);
          //this function must be in this ajax call because we are loading noteheader div with this call
          clickOnNote();
      }

    });


    //add a new note:Ajax call to createnote.php
    $("#addNote").click(function(){
       $.ajax({
           url:"createnote.php",
           success: function(data){
               if(data == 'error'){
                 $("#alertContent").text("There was an issue inserting the new note");
                 $("#alert").fadeIn();
               }else {
            //update activeNote with the id of the new note
                   activeNote = data;
                   $("textarea").val("");
            //show and hide elements
                   showHide(["#notePad", "#allNotes"], ["#notes", "#addNote", "#edit", "#done"]);
                   $("textarea").focus();
               }
           },
           error: function(){
               $('#alertContent').text("There was an error with the Ajax Call. Please try again later.");
               $("#alert").fadeIn();
           }
       });

    });

    //type notes:Ajax call to updatenote.php
    $("textarea").keyup(function(){
        //ajax call to update the task of id activenote
        $.ajax({
            url: "updatenote.php",
            type: "POST",
            //we need to send the current note content with its id to the php file
            data: {note: $(this).val(), id:activeNote},
            success: function (data){
                if(data === 'error'){
                    $('#alertContent').text("There was an issue updating the note in the database!");
                    $("#alert").fadeIn();
                }

                // $('#alertContent').text(data);
                // $("#alert").fadeIn();

            },
            error: function(){
                $('#alertContent').text("There was an error with the Ajax Call. Please try again later.");
                $("#alert").fadeIn();
            }

        });

    });









    //Cllick on all notes button
    $("#allNotes").click(function(){
        $.ajax({
            url:"loadnotes.php",
            success: function(data){

                showHide(["#notes", "#addNote", "#edit"],["#notePad", "#allNotes"]);
                $("#notes").html(data);
                //we must use this function here because of the ajax call after click on the allNotes button
                clickOnNote();
            },
            error: function(){
                $('#alertContent').text("There was an error with the Ajax Call. Please try again later.");
                $("#alert").fadeIn();
            }
        });

    });
    //click on done button after editing: load notes again
    //click on edit:go to edit mode(show delete buttons,....)

    //functions
       //click on  note
       function clickOnNote(){
           $(".noteheader").click(function(){
               //if we are not in edit mode(it's false)
               if(!editMode){
                   //update activeNote variable with the id of the noteheader
                   activeNote = $(this).attr('id');
                   //fill textarea
                   $('textarea').val($(this).find(".text").text());
                   //show and hide elements
                   showHide(["#notePad", "#allNotes"], ["#notes", "#addNote", "#edit", "#done"]);
                   //we are focusing the text area
                 $("textarea").focus();
               }
           });

       }
       //click on delete button
       //show Hide function





    function showHide(array1,array2){
        for(var i=0;i<array1.length;i++){
            $(array1[i]).show();
        }
        for(var i=0;i<array2.length;i++){
            $(array2[i]).hide();
        }
    }


});