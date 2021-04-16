$(function() {
    get_category(1);
    get_category(2);

    $(".change_category").on('change', function() {
        get_category(1);
        get_category(2);    
    });

    // Change Category in Jeopardy Game
    $('#category_double_r1').on('change', function() {
        $.ajax({
            type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
            url         : '/admin/dashboard/get_category_questions/'+this.value, // the url where we want to POST
            data        : "", // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
        })
        // using the done promise callback
        .done(function(data) {
            $('#category_question_double_r1').empty();
            for(var i = 0; i<data.data.questions.length; i++) {
                $("#category_question_double_r1").append(new Option(data.data.questions[i].question_text, data.data.questions[i].id));
            }
        });
    });


    $('#category_double_r2').on('change', function() {
        $.ajax({
            type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
            url         : '/admin/dashboard/get_category_questions/'+this.value, // the url where we want to POST
            data        : "", // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
        })
        // using the done promise callback
        .done(function(data) {
            $('#category_question_double_r2').empty();
            for(var i = 0; i<data.data.questions.length; i++) {
                $("#category_question_double_r2").append(new Option(data.data.questions[i].question_text, data.data.questions[i].id));
            }
        });
    });

});

function get_category(id) {
    $("#category_double_r"+id).empty();
    for(var i = 1; i<=5; i++) {
        txt = $("#category" + id + "_" + i.toString()).children("option:selected").text();
        val = $("#category" + id + "_" + i.toString()).children("option:selected").val();
        $("#category_double_r" + id).append(new Option(txt, val));
    }
}


function init_update_jeopardy_game() {
    
}