$(document).ready(function() {
    $('#login').click(function(){
        alert('click');

        $.ajax({
            url : '/php/test/test.php',
            type : 'post',
            dataType : 'json',
            data : ''
        }).done(function(data){

        }).fail(function(){
            alert('failed');
        });


        //return　false　しないとページ遷移してしまう。
        //これ必要？？
        return false;
    });
});