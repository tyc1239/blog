<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
 <form action="/material/add" enctype="multipart/form-data" method="post">
    @csrf

     <select name="type" id="">
         <option value="1" selected>临时</option>
         <option value="2">永久</option>


     </select>
    <input type="file" name="material" id="">
    <input type="submit" value="提交">
</form>

</body>
</html>
