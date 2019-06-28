<?php $long = strval(@$_GET['long']); ?>
<?php $short = strval(@$_GET['short']); ?>
<?php $respJson = strval(@$_POST['resp']); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>bit.ly</title>
    <!--    <script-->
    <!--        src="https://code.jquery.com/jquery-3.4.1.min.js"-->
    <!--        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="-->
    <!--        crossorigin="anonymous">-->
    <!--    </script>-->
    <style type="text/css">
        #url {
            width: 400px;
        }

        span {
            display: inline-block;
            width: 90px;
        }

    </style>
</head>

<body>
<form action="sender" method="get">
    <span>Long url:</span> <input id="url" type="text" name="url" value="<?= $long; ?>">
    <input type="submit" value="shorten" name="method">
</form>
<form action="sender" method="get">
    <span> Short url:</span> <input id="url" type="text" name="url" value="<?= $short; ?>">
    <input type="submit" value="expand" name="method">
</form>

<textarea rows="15" style='width:80%;'><?= $respJson; ?></textarea>

</br>
</body>

</html>
