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

            //alert (changeData.attr("id"));
            input.remove();
            dataCell.show();
            dataCell.removeClass("hidden-data-cell");
        }

        if ( ( $("input").is(changeData) && e.target.getAttribute("class") !== "change-data" ) )
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

        function hideClass()
        {
            $(e.target).addClass("hidden-data-cell");
            $(e.target).hide();
        }

        if (e.target.getAttribute("id") === "name" && !$("div").is(input))
        {
            hideClass();
            $(e.target).after(
                "<div class='table-cell table-change-data'><input id='new_city' class='change-data' value='"+$(e.target).html()+"'/></div>"
            );
        }
    }
);
    function addForm() {
    var city = $('#add_city').val();

    $.ajax({
        type: 'POST',
        url: 'core/ajaxAddCity.php',
        data:
        'city='+city,
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