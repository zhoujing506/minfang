<?php
/**
 * Created by PhpStorm.
 * User: zhoujing
 * Date: 2015/9/2
 * Time: 9:57
 */

include_once '../class/DB.php';

$json = ['code'=>0,'msg'=>'添加失败'];

$subjectFlag = showRequest($_REQUEST['subject'],'题目');
$optionAFlag = showRequest($_REQUEST['optionA'],'选项A');
$optionBFlag = showRequest($_REQUEST['optionB'],'选项B');
$optionCFlag = showRequest($_REQUEST['optionC'],'选项C');
$optionDFlag = showRequest($_REQUEST['optionD'],'选项D');
$answerFlag = showRequest($_REQUEST['answer'],'正确答案');
if($subjectFlag == true && $optionAFlag == true && $optionBFlag == true && $optionCFlag == true && $optionDFlag == true && $answerFlag == true){
    $subject = trim($_REQUEST['subject']);
    $optionA = trim($_REQUEST['optionA']);
    $optionB = trim($_REQUEST['optionB']);
    $optionC = trim($_REQUEST['optionC']);
    $optionD = trim($_REQUEST['optionD']);
    $answer = trim($_REQUEST['answer']);
    $sql = 'insert into questions (`subject`,`optionA`,`optionB`,`optionC`,`optionD`,`answer`) values (?,?,?,?,?,?)';
    $db = new DB();
    $lastId = $db->query($sql,[$subject,$optionA,$optionB,$optionC,$optionD,$answer]);
    if($lastId){
        $json = array_replace($json,['code'=>1,'msg'=>'添加成功']);
    }
}

echo json_encode($json);


function showRequest($param,$msg){
    if(!isset($param) || empty($param)){
        $json = ['code'=>0,'msg'=>'请输入'.$msg];
        echo json_encode($json,true);
        exit(0);
    }else{
        return true;
    }
}