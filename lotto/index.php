<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Lotto</title>
    </head>
    <body>
        <h1>Grotto... w sensie że lotto, ale skin w cs...</h1>

        <?php
            error_reporting(0);
            $connection = mysqli_connect("localhost", "root", "", "lotto");
            $r = mysqli_query($connection, "SELECT * FROM `results`;");
            $row = mysqli_fetch_array($r);
            
            echo $plik[0];
            echo "<br/>";

            if(empty($row['id'])){
                for($i = 0; $i <= 3999; $i++){
                    //j to miejsce kropki, ale chyba zadługa nazwa
                    $j = 0;
                    $id = "";
                    while($plik[$i][$j] != "."){
                        $id = $id . $plik[$i][$j];
                        $j++;
                    }

                    $data = $plik[$i][$j + 8] . $plik[$i][$j + 9] . $plik[$i][$j + 10] . $plik[$i][$j + 11] . "-" . $plik[$i][$j + 5] . $plik[$i][$j + 6] . "-" . $plik[$i][$j + 2] . $plik[$i][$j + 3];

                    $n1 = searchNumber($plik, $i, $j + 13)[0] . ".";
                    $j = searchNumber($plik, $i, $j + 13)[1];
                    $n2 = searchNumber($plik, $i, $j)[0] . ".";
                    $j = searchNumber($plik, $i, $j)[1];
                    $n3 = searchNumber($plik, $i, $j)[0] . ".";
                    $j = searchNumber($plik, $i, $j)[1];
                    $n4 = searchNumber($plik, $i, $j)[0] . ".";
                    $j = searchNumber($plik, $i, $j)[1];
                    $n5 = searchNumber($plik, $i, $j)[0] . ".";
                    $j = searchNumber($plik, $i, $j)[1];
                    $n6 = $plik[$i][$j] . $plik[$i][$j + 1] . "<br/>";

                //wrzucanie wartości do bazy (trzeba uzupełnić)
                    mysqli_query($connection, "INSERT INTO `results`(`id`, `result-date`, `n1`, `n2`, `n3`, `n4`, `n5`, `n6`) VALUES ('" . $id . "','" . $data . "','$n1','$n2','$n3','$n4','$n5','$n6')");
                }

                echo "<h1>Pomyślnie dodano 4000 wartości do tabelki. Przejdź <a href='repeats.php'>tutaj</a> aby zobaczyć jakie ile i jakie cyfry się powtarzają</h1>";
            }
            else{
                echo "<h1>Dane już zostały wprowadzone. Kliknij <a href='repeats.php'>tutaj</a> aby zobaczyć jakie ile i jakie cyfry się powtarzają</h1>";
            }

            function searchNumber($plik, $i, $j){
                $n = "";

                while($plik[$i][$j] != ","){
                    $n = $n . $plik[$i][$j];
                    $j++;
                }

                return [$n, $j + 1];
            }
        ?>
    </body>
</html>