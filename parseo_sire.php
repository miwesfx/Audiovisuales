<?PHP


$fila = 1;
if (($gestor = fopen("lista-recursos-sire.csv", "r")) !== FALSE) {
    while (($datos = fgetcsv($gestor, 0, ";")) !== FALSE) {
        $numero = count($datos);
        echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
        $fila++;
        for ($c=0; $c < 5; $c++) { //5 porque después se repite un campo y el resto son en blanco
            echo utf8_encode($datos[$c]) . "<br />\n";
        }
    }
    fclose($gestor);
}



?>