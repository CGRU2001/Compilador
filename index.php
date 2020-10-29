<?php
    if (isset($_POST["code"])){
        $code=strtolower($_POST["code"]);

        $codefixed=explode("\n",$code);
    }


    function buscar_errores($code){
        $errores=array();
        $opened=array();
        $ifopened=false;
        foreach ($code as $clave => $line){
            $linea=explode(" ",$line);
            if (trim($linea[0])=="if"||trim($linea[0])=="for"||trim($linea[0])=="while"||trim($linea[0])=="end"||trim($linea[0])=="else"||trim($linea[1]=='=')){
                if($linea[1]=='='){
                    $ifopened = true;
                }
                switch (trim($linea[0])){
                    case "if":
                        array_push($opened,$clave+1);
                        $ifopened=true;
                        break;
                    case "for":
                    case "while":
                        array_push($opened,$clave+1);
                        break;
                    case "end":
                        array_shift($opened);
                        break;
                    case "else":
                        if ($ifopened==false){
                            array_push($errores,$clave+1);
                        }
                        break;
                }
            }else{
                if (count($linea)>2&&(strpos($linea[0], '=') == false||strpos($linea[1], '=') == false)){
                    array_push($errores,$clave+1);
                }else{
                    switch (trim($linea[0])){
                        case "print":
                        case "tr":
                        case "tl":
                        case "deact":
                        case "a":
                        case "":
                            break;
                        default:
                            if (strpos($linea[0], '=') != false||strpos($linea[1], '=') != false){
                                if (strpos($linea[0], '=') != false){
                                    $variable=substr($linea[0], 0, strpos($linea[0],'='));
                                    if ($variable!=""){
                                        if (!ctype_alnum(str_replace('_', '', $variable))||!ctype_alpha($variable[0])){
                                            array_push($errores,$clave+1);
                                            break;
                                        }else{
                                            break;
                                        }
                                    }else{
                                        array_push($errores,$clave+1);
                                        break;
                                    }
                                }else{
                                    $variable=$linea[0];
                                    if ($variable!=""){
                                        if (!ctype_alnum(str_replace('_', '', $variable))||!ctype_alpha($variable[0])){
                                            array_push($errores,$clave+1);
                                            break;
                                        }else{
                                            break;
                                        }
                                    }
                                }
                            }
                            elseif (strpos($linea[0], '++') != false||strpos($linea[0], '--') != false){
                                break;
                            }
                            else{
                                array_push($errores,$clave+1);
                                break;
                            }
                    }
                }
            }
        }
        if (count($errores)>0||count($opened)>0){
            foreach ($errores as $valor){
                echo "<br>Error en la linea ".$valor;
            }
            foreach ($opened as $valor){
                echo "<br>Error en la linea ".$valor;
            }
        }
        else{
            echo "Codigo correcto";
        }
    }
?>
<!DOCTYPE html>
    <html>
        <head>
            <title>Compilador</title>
            <meta charset="UTf-8"/>
            <link rel="stylesheet" href="css/style.css"/>
        </head>
        <body>
            <div style="display: flex;flex-direction: column;justify-content: center;align-items: center;">
                <h1>Demeter</h1>
                <form method="post" action="index.php">
                    <label for="code">Inserta el código fuente aquí</label>
                    <textarea id="code" name="code"><?php if(isset($_POST['send'])){echo $_POST['code'];} ?></textarea>
                    <input type="submit" name="send" value="comprobar"/>
                    <?php
                    if(isset($_POST["send"]))
                    {
                        if($_POST["code"]=="") {
                            echo "<br>Error: No se ha escrito nada";
                        }else{
                            buscar_errores($codefixed);
                        }


                    }
                    ?>
                </form>
            </div>
        </body>
</html>
