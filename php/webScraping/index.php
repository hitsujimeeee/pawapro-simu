<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ウェブスクレイピング</title>
    <script src="../../js/plugin/jquery-3.1.1.min.js"></script>
    <script>
        function getURLList(allFlag) {
            $.post({
                data:{'allFlag':allFlag},
                url:'./getURLList.php'
            }).done(function(res){
                console.log(res);
            }).fail(function(res){
                console.log(res);
            });
        }

        function getTrickList(allFlag) {
            $.post({
                data:{
                    'allFlag':allFlag,
                    'trickFrom':Number($('#trickFrom').val()),
                    'trickTo':Number($('#trickTo').val()),
                },
                url:'./getTrickList.php'
            }).done(function(res){
                console.log(res);
            }).fail(function(res){
                console.log(res);
            });
        }

    </script>
</head>
<body>
    <div>
        <button onclick="getURLList(1);">URLリスト取得(全件)</button>
        <button onclick="getURLList(0);">URLリスト取得(差分)</button>
    </div>
    <div style="margin-top:1em;">
        <button onclick="getTrickList(1);">コツリスト取得(全件)</button>
        <button onclick="getTrickList(0);">コツリスト取得(差分)</button>
        <input type="number" id="trickFrom">～<input type="number" id="trickTo">
    </div>
    
</body>
</html>