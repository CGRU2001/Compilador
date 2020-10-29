<?php
    $line = 0;

    function checkline($may){
        for ($i=0; $i < count($may); $i++) { 
            $GLOBALS['line'] = ($i+1);

            if(!(checkVal($may[$i]))){
                return false;
            }
            
        }
        return true;
    }

    function checkVal($x){
        $txt = array('A', 'TR', 'TL', 'DEAC', 'PRINT');
        $vals = explode(' ',$x);
        print_r($vals);
        for ($i=0; $i < count($vals); $i++) { 
                if($vals[0]==$txt[$i] && @$vals[1] == '='){
                    return false;
                }
                if('A' == $vals[$i] && count($vals) == 1){
                    return true;
                }
                if('TR' == $vals[$i] && count($vals) == 1){
                    return true;
                }if('TL' == $vals[$i] && count($vals) == 1){
                    return true;
                }if('DEAC' == $vals[$i] && count($vals) == 1){
                    return true;
                }if('PRINT' == $vals[$i] && count($vals) == 2){
                    return true;
                }if(@$vals[1] == '='){
                    return true;
                }

            
        }
        return false;
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet"/>
    <title>Compilador</title>
</head>
<body>
    <h1>Aprende a programar con demeter</h1>
    <form method="post" action="index.php">
        <label for="code">Inserta el código fuente aquí</label>
        <textarea id="code" name="sourcecode"><?php if(isset($_POST['sourcecode'])){echo $_POST['sourcecode'];} ?></textarea>
        <input type="submit" name="send" value="comprobar"/>
    </form>
    <?php

        if(isset($_POST['send'])){
            if($_POST['sourcecode'] == ''){
                echo 'No se ha introducido nada';
            }else{
                $may = strtoupper($_POST['sourcecode']);
                $may = explode(PHP_EOL, $may);
                if(checkline($may)){
                    echo '<p>El código es válido</p>';
                }else{
                    echo '<p>Error en la línea '.$line.'</p>';
                }
                
            }
        }

    ?>
</body>
</html>