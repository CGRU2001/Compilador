<?php
    $line = 0;

    function checkline($may){
        for ($i=0; $i < count($may); $i++) { 
            if(!(checkVal($i))){
                return false;
            }
            
        }
        return true;
    }

    function checkVal($x){
        $txt = array('A', 'TR', 'TL', 'DEAC', 'PRINT');
        for ($i=0; $i < count($txt); $i++) { 
            if($txt[$i] == $x){
                return true;
            }
        }
        $line = $x;
        return false;
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compilador</title>
</head>
<body>
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
                print_r($may);
                if(checkline($may)){
                    echo 'El código es válido';
                }else{
                    echo 'Error en la línea '.$line;
                }
                
            }
        }

    ?>
</body>
</html>