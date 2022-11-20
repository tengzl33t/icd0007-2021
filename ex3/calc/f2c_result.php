<?php

$fartemp = intval($_POST["temperature"]);

$temp = round(($fartemp - 32) / (9/5));
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fahrenheit to Celsius</title>
</head>
<body>

    <nav>
        <a id="c2f" href="index.html">Celsius to Fahrenheit</a> |
        <a id="f2c" href="f2c.html">Fahrenheit to Celsius</a>
    </nav>

    <main>

        <h3>Fahrenheit to Celsius</h3>

        <?php
        if ($fartemp == 0): ?>
            <em>Insert temperature</em> /<br>
            <em>Temperature must be an integer</em> /<br>
        <?php else:?>
            <em><?= $fartemp ?> decrees in Fahrenheit is <?= $temp ?> decrees in Celsius</em>
        <?php endif ?>

    </main>

</body>
</html>