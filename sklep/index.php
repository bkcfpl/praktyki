<?php
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

            <h3 class = "cart"><a href="cart.php">koszyk</a></h3>
        </nav>

        <form action='item.php' method = 'post'>
            <?php
                for($i = 0; $i < $row = mysqli_fetch_array($r); $i++){
                    echo "<button type = 'submit' name = 'button' value = " . $i . ">";
                        echo "<div>";
                            echo "<img src='" . $row['zdjecie_link'] . "' alt='zdjęcie_przedmiotu_nr." . $i . "'>";
                            echo "<h3>" . $row['nazwa'] ."</h3>";

                            //nie wiem jak to inaczej zrobić, żeby jak jest cena np. 19.9 to żeby pokazywało 19.90
                            if($row['cena'] == 19.9){
                                echo "<p>" . $row['cena'] . "0zł</p>";
                            }
                            else{
                                echo "<p>" . $row['cena'] . "zł</p>";
                            }
                        echo "</div>";
                    echo "</button>";
                }
            ?>
        </form>
    </body>
</html>