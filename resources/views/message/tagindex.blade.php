<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="sendmessagebytag" method="post">
    @csrf

    <select name="" id="">
        @foreach($tags as $v)
            <option value="{{$v['id']}}">{{$v['name']}}</option>
        @endforeach
    </select>

    <input type="text" name="contents">
    <input type="submit" value="确认群发">
</form>
</body>
</html>