<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_store1";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Удаление товара из корзины и соответствующей записи из базы данных
if(isset($_GET['remove'])) {
    $id = $_GET['remove'];
    $delete_query = "DELETE FROM cart WHERE id=$id";
    if ($conn->query($delete_query) === TRUE) {
        echo "Товар успешно удален из корзины";
    } else {
        echo "Ошибка при удалении товара: " . $conn->error;
    }

    exit(0);
}

// Получение информации о товарах из таблицы корзины
$sql = "SELECT cart.id, products.product_name, products.price, cart.quantity
        FROM cart
        INNER JOIN products ON cart.product_id = products.id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAAAST FOOD - Corzine</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orelega+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="normalize.css">
</head>
<body>
    <header>
        <div class="main">
            <div class="header">
                <div class="logo">
                    <a href="index.html"><img src="./img/logo.svg"></a>
                </div>
                <div class="nav">
                    <a href="./carttt.php">Корзина</a>
                </div>
            </div>
    </header>
    <main>
        <div class="order">
            <h2>Корзина</h2>
        </div>
        <div class="vector">
            <img src="./img/Vector.png">
        </div>
        <table>
            <div class="bd_desc">
                <tr>
                    <th>Наименование товара</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Удалить</th>
                </tr>
            </div>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["product_name"]."</td>";
                    echo "<td>".$row["price"]."</td>";
                    echo "<td>".$row["quantity"]."</td>";
                    echo "<td><button onclick='removeFromCart(".$row["id"].")'>Удалить</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Корзина пуста</td></tr>";
            }
            ?>
        </table>
        <script>
            function removeFromCart(itemId) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert(xhr.responseText);
                        // Перезагрузка страницы после удаления товара
                        window.location.reload();
                    }
                };
                xhr.open("GET", "?remove=" + itemId, true);
                xhr.send();
            }
        </script>
    </main>
    <footer>    
    </footer>
</body>
</html>

<?php
// Закрытие соединения с базой данных
$conn->close();
?>

