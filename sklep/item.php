<?php
    $connect = mysqli_connect("localhost", "root", "", "sklep");

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

        <link rel="stylesheet" href="stylItem.css">
    </head>
    <body>
        <nav>
            <h2><a href="index.php">Sklep ŚPŚD</a></h2>

            <h3 class = "cart"><a href="cart.php">koszyk</a></h3>
        </nav>

        <form action="item.php" method = "post">
            <?php
                if($_POST['button'] != null){
                    $_SESSION['id'] = $_POST['button'] + 1;
                }

                $r = mysqli_query($connect, "SELECT * FROM `produkty` WHERE `id` = " . $_SESSION['id'] . ";");
                $row = mysqli_fetch_array($r);

                echo "<main>";
                    echo "<section>";
                        echo "<img src='" . $row['zdjecie_link'] . "' alt='zdjęcie_przedmiotu_nr." . $_POST['button'] . "'>";
                        echo "<h3>" . $row['nazwa'] ."</h3>";
                        echo "<i>" . $row['opis'] ."</i>";
                    echo "</section>";
                    
                    echo "<section class = 'price'>";

                        //nie wiem jak to inaczej zrobić, żeby jak jest cena np. 19.9 to żeby pokazywało 19.90
                        if($row['cena'] == 19.9){
                            echo "<p id = 'price'>" . $row['cena'] . "0zł</p>";
                        }
                        else{
                            echo "<p id = 'price'>" . $row['cena'] . "zł</p>";
                        }

                        echo "<p>Wprowadź ilość produktu, jaką chcesz kupić:</p>";
                        echo "<input type = 'text' name = 'ilosc' value = '1'><br/>";

                        echo "<button type = 'submit' name = 'sure'><h3>Dodaj do koszyka</h3></button>";
                    echo "</section>";
                echo "</main>";

                $summary = round($row['cena'] * $_POST['ilosc'], 2);
                $loop = true;
                $i = 0;
                if($summary != 0){
                    while($loop){
                        if($_SESSION['koszyk'][$i][0] == null){
                            $loop = false;
                            $_SESSION['koszyk'][$i][0] = $row['nazwa'];
                            $_SESSION['koszyk'][$i][1] = $_POST['ilosc'];
                            $_SESSION['koszyk'][$i][2] = $summary;

                            header( 'Location: http://localhost/sklep/cart.php' );
                        }
                        else{
                            $i++;
                        }
                    }
                }
            ?>
        </form>
    </body>
</html>