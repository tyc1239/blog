<link rel="stylesheet" href="{{asset('css/page.css')}}" type="text/css">
@if (session('msg'))
 <div class="alert alert-success">
 {{ session('msg') }}
 </div>
@endif
<form action="">
		<input  name="username" value="{{$username}}" placeholder="请输入关键名字">
		<select name="age" >
				<option value="">--请选择年龄--</option>
				<option value="16" @if($age==16) selected @endif>16</option>
				<option value="17" @if($age==17) selected @endif>17</option>
				<option value="18" @if($age==18) selected @endif>18</option>
				<option value="19" @if($age==19) selected @endif>19</option>
				<option value="20" @if($age==20) selected @endif>20</option>

		
		</select>
		<button>搜索</button>

</form>


@foreach($data as $key=>$val)

<p> ID:{{$val->uid}}
	name:{{$val->username}}
	性别：@if($val->sex==1)女 @else 男 @endif
	年龄：{{$val->age}}
	班级：{{$val->class}}
	头像：<img src="http://upload.com/{{$val->head}}" width="100px">
	操作：<a href="del?uid={{$val->uid}}">删除</a> <a href="{{route('edituser',['id'=>$val->uid])}}">修改</a>
</p>

@endforeach

{{$data->links()}}