<?php

$data = urlencode($_GET['text']) ?? '';
$confirmed = isset($_GET['confirmed']);
$decoded = urldecode($data);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>

<?php if($confirmed) {
    print "Confirmed: $decoded";
} else {
    print "<a href='.'>Cancel</a> ";
    print "<a href='receiver.php?confirmed=1&text=$data'>Confirm</a>";
}

?>

</body>
</html>
