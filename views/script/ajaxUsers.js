$(document).ready(function(){

$('#send-message-form').submit(function (event) {
    event.preventDefault();
    addForm();
});

$(document).mouseup(function (e)
    {
        var dataCell = $(".hidden-data-cell");
        var input = $(".table-change-data");
        var changeData= $(".change-data");

        function changeDataFunction()
        {
            changeForm(dataCell.parent().attr("id"),changeData.attr("id"),changeData.val());

            input.remove();
            dataCell.show();
            dataCell.removeClass("hidden-data-cell");
        }

        function hideClass()
        {
            $(e.target).addClass("hidden-data-cell");
            $(e.target).hide();
        }

        if ( ( $("input").is(changeData) && e.target.getAttribute("class") !== "change-data" )
            || ( $("select").is(changeData) && e.target.getAttribute("class") !== "change-data" ) )
        {
            changeDataFunction();
            return;
        }
        $(changeData).keydown(function(e) {
            if(e.keyCode === 13)
            {
                changeDataFunction();
            }
        });

        if(e.target.getAttribute("id") === "name" && !$("div").is(input))
        {
            hideClass();
            $(e.target).after(
                "<div class='table-cell table-change-data'><input id='name' class='change-data' value='"+$(e.target).html()+"'/></div>"
            );
        }

        if(e.target.getAttribute("id") === "age" && !$("div").is(input))
        {
            hideClass();
            $(e.target).after(
                "<div class='table-cell table-change-data'><input id='age' class='change-data' value='"+$(e.target).html()+"'/></div>"
            );

        }

        if(e.target.getAttribute("id") === "city" && !$("div").is(".table-change-data"))
        {
            hideClass();
            $(e.target).after(
                "<div class='table-cell table-change-data'><select id='city' class='change-data'><option value='0'>Город не выбран</option></select></div>"
            );
            selectForm(e.target.getAttribute("data-city"));
        }
    }
);

function selectForm (cityId){
    $.ajax({
        type: 'POST',
        url: 'core/ajaxSelect.php',
        data:
        'cityId='+cityId,
        success: function(html){
            $('.change-data').append(html);
        }
    })
}

function addForm() {
    var name = $('#add_name').val();
    var age = $('#add_age').val();
    var city = $('#add_city').val();

    $.ajax({
        type: 'POST',
        url: 'core/ajaxAddUser.php',
        data:
        'name='+name+'&age='+age+'&city='+city,
        success: function (data){
            result(data);
        }
    });
}

function changeForm(id,div_class,value) {

    $.ajax({
        type: 'POST',
        url: 'core/ajaxChange.php',
        data:
        'id='+id+'&dataName='+div_class+'&value='+value,
        success: function (data){
            result(data);
        }
    });
}

function result(data) {
    $('#result').html(data);
}

});