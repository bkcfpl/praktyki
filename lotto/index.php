<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Lotto</title>
    </head>
    <body>
        <h1>Grotto... w sensie że lotto, ale skin w cs...</h1>
        <br/>

        <?php
            error_reporting(0);
            $connection = mysqli_connect("localhost", "root", "", "lotto");
            $r = mysqli_query($connection, "SELECT * FROM `results`;");
            $row = mysqli_fetch_array($r);
            $plik = file("C:\Users\Praktykant\Downloads\dl.txt");

            if(empty($row['id'])){
                $arr = [];
                for($i = 0; $i <= 3999; $i++){
                    $linijka = explode(".", $plik[$i]);
                    $rok = explode(" ", $linijka[3]);
                    $liczba = explode(",", $rok[1]);

                    $id = $linijka[0];
                    echo $data = $rok[0] . "-" . $linijka[2] . "-" . trim($linijka[1]);

                    $arr[] = "('" . $id . "','" . $data . "','" . $liczba[0] . "','" . $liczba[1] . "','" . $liczba[2] . "','" . $liczba[3] . "','" . $liczba[4] . "','" . $liczba[5] . "')";
                }
                
                $chunks = array_chunk($arr, 500);
                foreach ($chunks as $chunk) {
                    mysqli_query($connection, "INSERT INTO `results`(`id`, `result-date`, `n1`, `n2`, `n3`, `n4`, `n5`, `n6`) VALUES " . implode(",", $chunk));
                }

                echo "<h1>Pomyślnie dodano 4000 wartości do tabelki. Przejdź <a href='repeats.php'>tutaj</a> aby zobaczyć jakie ile i jakie cyfry się powtarzają</h1>";
            }
            else{
                echo "<h1>Dane już zostały wprowadzone. Kliknij <a href='repeats.php'>tutaj</a> aby zobaczyć jakie ile i jakie cyfry się powtarzają</h1>";
            }
        ?>
    </body>
</html>