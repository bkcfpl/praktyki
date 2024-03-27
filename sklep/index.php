<?php
    //łączenie z bazą danych sklep, i tabelką produkty
    $connect = mysqli_connect("localhost", "root", "", "sklep");
    $r = mysqli_query($connect, "SELECT * FROM `produkty`");

    session_start();
    error_reporting(0);
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Sklep ŚPŚD</title>

        <link href="https://fonts.googleapis.com/css2?family=Konkhmer+Sleokchher&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong" rel="stylesheet">

        <link rel="stylesheet" href="stylIndex.css">
    </head>
    <body>
        <nav>
            <h2><a href="index.php">Sklep ŚPŚD</a></h2>

            <h3 class = "login"><a href="login.php">zaloguj</a></h3>
            <h3 class = "cart"><a href="cart.php">koszyk</a></h3>
        </nav>

        <form action='item.php' method = 'post'>
            <table>
                <tr>
                    <?php
                        //pętla będzie się powtarzać dopóki nie wyświetli wszystkich produktów
                        for($i = 0; $i < $row = mysqli_fetch_array($r); $i++){
                            echo "<td>";
                                //wszystko jest w przycisku, żeby strona wiedziała jaki produkt został kliknięty
                                echo "<button type = 'submit' name = 'button' value = " . $i . ">";
                                    echo "<div>";
                                        echo "<img src='" . $row['zdjecie_link'] . "' alt='zdjęcie_przedmiotu_nr." . $i . "'>";
                                        echo "<h3>" . $row['nazwa'] ."</h3>";
                                        echo "<p>" . number_format($row['cena'], 2) . "zł</p>"; //zaokrągla do dwóch cyfr po przecinku, żeby zamiast 19.9 było 19.90
                                    echo "</div>";
                                echo "</button>";
                            echo "<td>";

                            //maksymalnie 3 produkty na wiersz
                            if(($i + 1) % 3 == 0){
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                    ?>
                </tr>
            </table>
        </form>
    </body>
</html>