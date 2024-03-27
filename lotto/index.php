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
            //niewyświetlanie błędów, łączenie z bazą danych
            error_reporting(0);
            $connection = mysqli_connect("localhost", "root", "", "lotto");
            $r = mysqli_query($connection, "SELECT * FROM `results`;");
            $row = mysqli_fetch_array($r);

            //zmienna $plik ma wartość pobranego pliku
            $plik = file("C:\Users\Praktykant\Downloads\dl.txt");

            //jeśli pierwsze id jest puste
            if(empty($row['id'])){
                $arr = [];
                //4000 razy zapisuje kawałki linijek pliku, do zmiennych, odzielonych tym, co jest pomiędzy ""
                for($i = 0; $i <= 3999; $i++){
                    $linijka = explode(".", $plik[$i]);
                    $rok = explode(" ", $linijka[3]);
                    $liczba = explode(",", $rok[1]);

                    //ustawia id i datę
                    $id = $linijka[0];

                    //zapisuje wszystko do tablicy
                    $arr[] = "('" . $id . "','" . $data . "','" . $liczba[0] . "','" . $liczba[1] . "','" . $liczba[2] . "','" . $liczba[3] . "','" . $liczba[4] . "','" . $liczba[5] . "')";
                }
                
                //zmienia array 4000 linijek na tablice po 500 na tablicę
                $chunks = array_chunk($arr, 500);

                //wpisuje wartości do bazy danych, masowo (po 500)
                foreach ($chunks as $chunk) {
                    mysqli_query($connection, "INSERT INTO `results`(`id`, `result-date`, `n1`, `n2`, `n3`, `n4`, `n5`, `n6`) VALUES " . implode(",", $chunk));
                }

                echo "<h1>Pomyślnie dodano 4000 wartości do tabelki. Przejdź <a href='repeats.php'>tutaj</a> aby zobaczyć jakie ile i jakie cyfry się powtarzają</h1>";
            }
            //jeśli pierwsze id NIE jest puste
            else{
                echo "<h1>Dane już zostały wprowadzone. Kliknij <a href='repeats.php'>tutaj</a> aby zobaczyć jakie ile i jakie cyfry się powtarzają</h1>";
            }
        ?>
    </body>
</html>