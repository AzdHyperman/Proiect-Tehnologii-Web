<?php
$f_name="Derek";
$age=33;
$height=1.59;
$banned=false;
$address=array('street'=>'123 Main st','city'=>'Iasi');
$state=NULL;
define('PI',3.1414);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP tutorial</title>
</head>
<body>
    <p>Name: <?php echo $f_name. ' ' . $address['street']; ?></p>
    
</body>
</html>