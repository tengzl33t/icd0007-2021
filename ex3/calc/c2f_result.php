<?php

$celstemp = intval($_POST["temperature"]);

$temp = round($celstemp * 9/5 + 32);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Celsius to Fahrenheit</title>
</head>
<body>

    <nav>
        <a id="c2f" href="index.html">Celsius to Fahrenheit</a> |
        <a id="f2c" href="f2c.html">Fahrenheit to Celsius</a>
    </nav>

    <main>

        <h3>Celsius to Fahrenheit</h3>
        <?php
            if ($celstemp == 0): ?>
            <em>Insert temperature</em> /<br>
            <em>Temperature must be an integer</em> /<br>
            <?php else:?>
                <em><?= $celstemp ?> decrees in Celsius is <?= $temp ?> decrees in Fahrenheit</em>
            <?php endif
        ?>

    </main>

</body>
</html>