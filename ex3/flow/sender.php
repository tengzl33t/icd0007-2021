<?php
$data = $_GET['text'] ?? '';

if(!empty($data)) {
    $val = urlencode("Data was: " . $data);
    header("Location: receiver.php?text=".$val);
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>

<form>
    <label for="ta">Message:</label>
    <br>
    <textarea id="ta" name="text"></textarea>
    <br>
    <button name="sendButton" type="submit">Send</button>
</form>

</body>
</html>
