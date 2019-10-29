<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="sendmessage" method="post">
    @csrf
        请输入群发内容： <input type="text" name="desc">
        <input type="submit" value="确认群发">
</form>
</body>
</html>