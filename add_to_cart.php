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

// Получение кода товара из POST запроса
$product_code = $_POST['product_code'];

// Получение ID товара из базы данных по его коду
$sql = "SELECT id FROM products WHERE product_code='$product_code'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $product_id = $row["id"];
    
    // Добавление товара в корзину
    $insert_query = "INSERT INTO cart (product_id, quantity) VALUES ($product_id, 1)";
    if ($conn->query($insert_query) === TRUE) {
        echo "Товар успешно добавлен в корзину";
    } else {
        echo "Ошибка: " . $conn->error;
    }
} else {
    echo "Товар с указанным кодом не найден";
}

// Закрытие соединения с базой данных
$conn->close();
?>