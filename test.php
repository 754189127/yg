<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-5-17
 * Time: 下午5:35
 */

$n=10;
$m=3;
$arr = array();
for($i=0;$i<=$n;$i++){
    $arr[$i] =$i;
    if($i==$m){
       unset[$arr[$i]];
    }
}