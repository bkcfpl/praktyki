<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Powtórzenia</title>
    </head>
    <body>
        <?php
            $connection = mysqli_connect('localhost', "root", "", "lotto");

            for($i = 0; $i < 99; $i++){
                $repeats[$i] = 0;
                $r = mysqli_query($connection, "SELECT * FROM `results` WHERE `n1` = $i OR `n2` = $i OR `n3` = $i OR `n4` = $i OR `n5` = $i OR `n6` = $i");
                while($row = mysqli_fetch_array($r)){
                    $repeats[$i] ++;
                }

                echo "id: " . $i . ", powtórzenia: " . $repeats[$i] . "<br/>";

                $r = mysqli_query($connection, "SELECT * FROM `repeats`");
                $row = mysqli_fetch_array($r);
                if(!empty($row['id'])){
                    mysqli_query($connection, "INSERT INTO `repeats`(`number`, `repeats`) VALUES ('$i','" . $repeats[$i] . "')");
                }
                else{
                    mysqli_query($connection, "UPDATE `repeats` SET `repeats`='" . $repeats[$i] . "' WHERE `number` = $i ");
                }
            }
            echo "<h2>Policzno wszystkie lizcby, i zapisano je do bazy danych!</h2>";
        ?>
    </body>
</html>