<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户绑定</title>
</head>
<body>
<form action="/wechat/bindingdo">
    请输入绑定账号：<input type="text" name="username">
    <input type="hidden" value="{{$userinfo}}" name="userinfo">
    <input type="submit" value="绑定">

</form>


</body>
</html>