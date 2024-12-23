<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "ifruit";

$connection = mysqli_connect($host, $user, $pass, $db);

if (!$connection) {
    echo "Cannot connect to database";
}

$fruidId = "";
$fruitName = "";
$fruitType = "";
$stock = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruit Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="mx-auto">
        <div class="card"><span class="border border-white">
                <div class="card-header bg-secondary text-light">
                    Fruit Data
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="color: white">Fruit ID</th>
                                <th scope="col" style="color: white">Fruit Name</th>
                                <th scope="col" style="color: white">Fruit Type</th>
                                <th scope="col" style="color: white">Stock</th>
                            </tr>
                        <tbody>
                            <?php
                            $sql2 = "SELECT * FROM fruit ORDER BY fruitId ASC";
                            $q2 = mysqli_query($connection, $sql2);

                            while ($r2 = mysqli_fetch_array($q2)) {
                                $fruitId = $r2['fruitId'];
                                $fruitName = $r2['fruitName'];
                                $fruitType = $r2['fruitType'];
                                $stock = $r2['stock'];
                                ?>
                                <tr>
                                    <td scope="row" style="color: white"><?php echo $fruitId ?></td>
                                    <td scope="row" style="color: white"><?php echo $fruitName ?></td>
                                    <td scope="row" style="color: white"><?php echo $fruitType ?></td>
                                    <td scope="row" style="color: white"><?php echo $stock ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        </thead>
                    </table>
                </div>
            </span>
        </div>

        <div class="mx-auto">
            <div class="card">
                <?php
                // To make a list of fruits without duplicate names
                $sql = "SELECT DISTINCT fruitName FROM fruit";
                $result = mysqli_query($connection, $sql);
                echo 'Buah yang dimiliki: ';

                if ($result && mysqli_num_rows($result) > 0) {
                    $fruitNames = []; // Initialize an array to store the fruit names
                    while ($row = mysqli_fetch_assoc($result)) {
                        $fruitNames[] = htmlspecialchars($row['fruitName']);
                    }
                    // Join the names with commas and display them
                    echo implode(', ', $fruitNames);
                } else {
                    echo 'Tidak ada buah yang terdaftar.';
                }
                ?>
            </div>
        </div><br>

        <div class="mx-auto">
            <div class="card">
                <?php
                // Group fruits by their type, ensuring no duplicates
                $sql = "SELECT fruitType, GROUP_CONCAT(DISTINCT fruitName) AS fruitNames FROM fruit GROUP BY fruitType";
                $result = mysqli_query($connection, $sql);
                echo 'Wadah: ';

                if ($result && mysqli_num_rows($result) > 0) {
                    $containerCount = 0; // Count the number of containers
                    while ($row = mysqli_fetch_assoc($result)) {
                        $containerCount++; // Increment the container count
                        $fruitType = htmlspecialchars($row['fruitType']);
                        $fruitNames = htmlspecialchars($row['fruitNames']);
                        echo "<p>$fruitType: $fruitNames</p>";
                    }
                    echo "<p>Jumlah wadah yang dibutuhkan: $containerCount</p>";
                } else {
                    echo 'Tidak ada buah yang terdaftar.';
                }
                ?>
            </div>
        </div><br>

        <div class="mx-auto">
            <div class="card">
                <?php
                // Calculate the total stock of all fruits
                $sql = "SELECT SUM(stock) AS totalStock FROM fruit";
                $result = mysqli_query($connection, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $totalStock = $row['totalStock'];
                    echo "<p>Total stock: $totalStock</p>";
                } else {
                    echo '<p>Total stock: 0</p>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>

<!-- Komentar: Untuk yang soal nomor 2, aku tidak tahu caranya untuk kasih spasi setelah koma. -->