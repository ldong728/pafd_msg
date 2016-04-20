
$(document).ready(function(){


    $('div.maincate').click(function(){   //分类按钮点击
        $.post('ajax.php?get_sub_category=1',{category:$(this).attr("id")},function(result){
            $('#tempd').empty();
            //$('#tempd').append(result);
            var data= eval('('+result+')');
            //var n= data.length;

            //$('#tempd').append(n);
            $.each(data,function(id,value){
                $('#tempd').append(value['name']);
            })

        });
        //$('#tempd').append('hahahahahahahah');

    });




});