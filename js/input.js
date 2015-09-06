/**
 * Created by zhoujing on 2015/9/2.
 */
$(function(){
    $('#inputBtn').click(function(){
        var subject = $('#subject').val();
        var optionA = $('#optionA').val();
        var optionB = $('#optionB').val();
        var optionC = $('#optionC').val();
        var optionD = $('#optionD').val();
        var answer = $('#answer').val();
        var flag = true;
        //var flag = showRequest(subject,optionA,optionB,optionC,optionD,answer);
        if(flag == true){
            $.ajax({
                url:'app/input.php',
                dataType:'json',
                type:'post',
                data:{subject:subject,optionA:optionA,optionB:optionB,optionC:optionC,optionD:optionD,answer:answer},
                success:function(obj){
                    if(obj.code == 0){
                        alert(obj.msg);
                    }else{
                        alert(obj.msg);
                        $(':input','.elegant-aero')
                            .not(':button, :submit, :reset, :hidden')
                            .val('');
                    }
                }
            });
        }
    });
});

function showRequest(subject,optionA,optionB,optionC,optionD,answer){
    var flag = true;
    if(subject == "" || subject == null || subject.length == 0){
        alert("请输入题目");
        flag = false;
    }
    if(optionA == "" || optionA == null || optionA.length == 0){
        alert("请输入选项A");
        flag = false;
    }
    if(optionB == "" || optionB == null || optionB.length == 0){
        alert("请输入选项B");
        flag = false;
    }
    if(optionC == "" || optionC == null || optionC.length == 0){
        alert("请输入选项C");
        flag = false;
    }
    if(optionD == "" || optionD == null || optionD.length == 0){
        alert("请输入选项D");
        flag = false;
    }
    if(answer == "" || answer == null || answer.length == 0){
        alert("请输入正确答案");
        flag = false;
    }
    return flag;
}
