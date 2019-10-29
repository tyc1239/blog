<?php

namespace App\Http\Controllers\Admin;

use App\Model\Material;
use App\Model\Wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cach;


class MaterialController extends Controller
{
    //
    public  function  index(Request $request)
    {
        $query=request()->all();
        $where=[];
        $type=$query['type']??'';
         if ($type) {
            $where[]=['name','like',"%$type%"];
        }

        $data=DB::table('subscribe')->where($where)->paginate(3);
        $line=$data['line'];
         return view('admin.subscribelist',['data'=>$data,'line'=>$line,'type'=>$type, 'query'=> $query]);

    }


    public  function getlist(Request $request)
    {
        $query=request()->all();
//        $num = Material::where('type',$type)->count();
//        $token = Wechat::GetAccessToken();
//        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$token";
//            $postdata = [
//                'type'=>'image',
//                'offest'=>0,
//                'count'=>20
//            ];
//        $json = json_encode($postdata,JSON_UNESCAPED_UNICODE);
//        $re = Wechat::HttpPost($url,$json);
//        dd($re);
        $data="{\"item\":[{\"media_id\":\"8HiSR-Qr1-8hl3BVb468asjA4yCMVWLT6Q1H1mOILB4\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/47880.png\",\"update_time\":1557403445,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_png\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGHOszt99iaQoKgicP4YO6Ht4ibiaib3USqcceg2S4TicXssCQPNkQLAHND0wLA\/0?wx_fmt=png\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468ap70lhIOHCMMjAoymYrPI-w\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/88258.png\",\"update_time\":1557403309,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_png\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGHOszt99iaQoKgicP4YO6Ht4ibiaib3USqcceg2S4TicXssCQPNkQLAHND0wLA\/0?wx_fmt=png\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468ahQsBXGgq7BsPv54CTnfA3I\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/25958.png\",\"update_time\":1557403296,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_png\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGHOszt99iaQoKgicP4YO6Ht4ibiaib3USqcceg2S4TicXssCQPNkQLAHND0wLA\/0?wx_fmt=png\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468aiTq9etzjR5sn2DO4o4zdeQ\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/63597.jpg\",\"update_time\":1557403119,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_png\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGH0sUkjFgJ7aOWknDU6usA5yAdwsrtHKl9DgTcnQb7omFu0JKRyiaicIvQ\/0?wx_fmt=png\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468arDyzg29oF-5QjhmVtlz49o\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/83962.jpg\",\"update_time\":1557403055,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_jpg\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGHhtQ1yh4fibdIvrwJPXm33TNxFAyzlwOngXyusto5MezZAeRpHZOs3rA\/0?wx_fmt=jpeg\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468at9HI7yBe1bWK-MQezaUlSU\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/13895.jpg\",\"update_time\":1557402838,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_png\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGH0sUkjFgJ7aOWknDU6usA5yAdwsrtHKl9DgTcnQb7omFu0JKRyiaicIvQ\/0?wx_fmt=png\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468aoF3D-2pMYDBtc8TxNOV2mU\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/84170.jpg\",\"update_time\":1557402810,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_png\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGH0sUkjFgJ7aOWknDU6usA5yAdwsrtHKl9DgTcnQb7omFu0JKRyiaicIvQ\/0?wx_fmt=png\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468arB-hteNZe3ZvVkUfpr-o_g\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/40544.jpg\",\"update_time\":1557402738,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_png\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGH0sUkjFgJ7aOWknDU6usA5yAdwsrtHKl9DgTcnQb7omFu0JKRyiaicIvQ\/0?wx_fmt=png\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468arIkzUNXYYECEVZHJ8lvtaU\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/86433.jpg\",\"update_time\":1557400564,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_png\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGH0sUkjFgJ7aOWknDU6usA5yAdwsrtHKl9DgTcnQb7omFu0JKRyiaicIvQ\/0?wx_fmt=png\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468agciJeeeDT-eON0M2tDZYAo\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/88977.jpg\",\"update_time\":1557400442,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_png\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGH0sUkjFgJ7aOWknDU6usA5yAdwsrtHKl9DgTcnQb7omFu0JKRyiaicIvQ\/0?wx_fmt=png\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468asbmFEudGEl2Flr4dW5IVTE\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/97842.jpg\",\"update_time\":1557399970,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_jpg\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGHXDcETdUmAxOjv3NnL3juMe8cwVYJvmug0fKgNxyyTzDxgdUuneeQ4w\/0?wx_fmt=jpeg\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468anDmxKVv8JC-dARXjvBIiqg\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/64275.jpg\",\"update_time\":1557399928,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_jpg\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGHXDcETdUmAxOjv3NnL3juMe8cwVYJvmug0fKgNxyyTzDxgdUuneeQ4w\/0?wx_fmt=jpeg\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468ahOsJhcdjPP_Hjla5vwwjgE\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/98328.jpg\",\"update_time\":1557389916,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_jpg\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGHXDcETdUmAxOjv3NnL3juMe8cwVYJvmug0fKgNxyyTzDxgdUuneeQ4w\/0?wx_fmt=jpeg\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468ajJkg4F4aGjFMEi181KZaSI\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/40104.jpg\",\"update_time\":1557389748,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_jpg\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGHXDcETdUmAxOjv3NnL3juMe8cwVYJvmug0fKgNxyyTzDxgdUuneeQ4w\/0?wx_fmt=jpeg\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468apX4oKvSxq4Jq52-hmyYFZI\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/64794.jpg\",\"update_time\":1557389469,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_png\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGH0sUkjFgJ7aOWknDU6usA5yAdwsrtHKl9DgTcnQb7omFu0JKRyiaicIvQ\/0?wx_fmt=png\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468ahgwUNCJYhiuovYhhMgHAI8\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/88060.jpg\",\"update_time\":1557389340,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_png\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGH0sUkjFgJ7aOWknDU6usA5yAdwsrtHKl9DgTcnQb7omFu0JKRyiaicIvQ\/0?wx_fmt=png\"},{\"media_id\":\"8HiSR-Qr1-8hl3BVb468au5iS5XlH7Hdtfa05uGjisU\",\"name\":\"\/data\/wwwroot\/default\/blog\/public\/uploads\/20190509\/49727.jpg\",\"update_time\":1557389291,\"url\":\"http:\/\/mmbiz.qpic.cn\/mmbiz_jpg\/709rsb5BQudy3JXBBZzL9icpW8jERiaLGHXDcETdUmAxOjv3NnL3juMe8cwVYJvmug0fKgNxyyTzDxgdUuneeQ4w\/0?wx_fmt=jpeg\"}],\"total_count\":17,\"item_count\":17}";
        $info =json_decode($data,true)['item'];
        $res = DB::table('material')->insert($info);
        $data = DB::table('material')->paginate(5);
        $line=$data['line'];
        return view('admin/materiallist',['data'=>$data,'query'=> $query,'line'=>$line]);

//        $info =json_decode($re,true);
//        $count = $info['item_count'];
//        $data = $info ['item'];
//        for($i=0;$i<$count;$i++)
//        {
//           $data[$i]['type']=$type;
//        }
//        Material::insert($info['item']);



        return view('admin.materiallist');
    }
    public function del($media_id)

    {
        $token =$token = Wechat::GetAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=$token";
        $media_id = [
            "media_id"=>$media_id
        ];
        $json = json_encode($media_id);
        $post = Wechat::HttpPost($url,$json);
        $res = json_decode($post,true);
        if($res){
            DB::table('material')->where('media_id',$media_id)->delete();
            echo"<script>alert('删除成功');location.href='/admin/materiallist'</script>";
        }else{
            echo"<script>alert('删除失败');location.href='/admin/materiallist'</script>";
        }
    }

}
