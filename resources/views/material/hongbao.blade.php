<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="/material/hbaddo" method="post">

    {{--<table>--}}
        {{--<tr align="center">--}}
             {{--<td>头像</td>--}}
            {{--<td>昵称</td>--}}

        {{--</tr>--}}
        {{--@if($fans)--}}
            {{--@foreach($fans as $v)--}}
                {{--<tr align="center">--}}
                     {{--<td><img src="{{$v['headimgurl']}}" width="60px;"></td>--}}
                    {{--<td>{{$v['nickname']}}</td>--}}

                {{--</tr>--}}
            {{--@endforeach--}}
        {{--@endif--}}

    {{--</table>--}}

    <h4>红包算法</h4>

         总金额:<input type="text" name="money" id="">
        人数：<input type="text" name="num" id="">
        <input type="submit" value="发红包">

</form>

</body>
</html>

<?php
   /*
    * 红包实现思路
    *
    * 1、设定红包总金额
    * 2、设定红包的数量
    * 3、设定每个人最少收到的红包金额
    * 4、存入随机红包金额结果
    * 5、进行循环，随即安全上限
    * 6、输出红包金额
    * */
/*
 * $total=200;
$num=10;
$min=0.01;
$money_arr=array();
for ($i=1;$i<$num;$i++)
{
    $safe_total=($total-($num-$i)*$min)/($num-$i);

    $money= mt_rand($min*100,$safe_total*100)/100;

    $total=$total-$money;

    $money_arr[]= $money;

    echo '第'.$i.'位分得：'.$money.' 元 '."<br/>";
}
echo '第'.$num.'个红包：'.round($total,2).' 元'. '总金额 100元';
 * */

// 使用for 循环输出一个菱形九九乘法表
echo "<table width='600' border='1' style='float: left;'>";

for($j=1;$j<=9;$j++){

    echo "<tr>";

    for($z=0;$z<9-$j;$z++){

        echo "<td> </td>";

    }

    for($i=$j;$i>=1;$i--){

        echo "<td>{$i}*{$j}=".($i*$j)."</td>";

    }

    echo "</tr>";

}

echo "</table>";

echo "<table width='600' border='1'>";

for($j=1;$j<=9;$j++){

    echo "<tr>";

    for($i=1;$i<=$j;$i++){

        echo "<td>{$i}*{$j}=".($i*$j)."</td>";

    }

    echo "</tr>";

}

echo "</table>";

echo "<table width='600' border='1' style='float: left;'>";

for($j=9;$j>=1;$j--) {

    echo "<tr>";

    for ($z = 0; $z < 9 - $j; $z++) {

        echo "<td> </td>";

    }

    for ($i = 1; $i <= $j; $i++) {

        echo "<td>{$i}*{$j}=" . ($i * $j) . "</td>";

    }

}

echo "</table>";

echo "<table width='600' border='1'>";

for($j=9;$j>=1;$j--){

    echo "<tr>";

    for($i=1;$i<=$j;$i++){

        echo "<td>{$i}*{$j}=".($i*$j)."</td>";

    }

    echo "</tr>";

}
 ?>

