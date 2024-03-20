<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$db = new PDO('sqlite:visits.db');
$visits = $db->query('SELECT * FROM visits')->fetchAll(PDO::FETCH_ASSOC);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Статистика посещений</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Статистика посещений</h1>

<table>
    <tr>
        <th>IP</th>
        <th>Страна</th>
        <th>Город</th>
        <th>Устройство</th>
    </tr>
    <?php foreach($visits as $visit): ?>
    <tr>
        <td><?php echo $visit['ip']; ?></td>
        <?php
        // Запрашиваем данные из API
        $apiResponse = file_get_contents("https://api.ip2location.io/?ip={$visit['ip']}");
        $apiData = json_decode($apiResponse, true);
        ?>
        <td><?php echo $apiData['country_name'] ?? 'Неизвестно'; ?></td>
        <td><?php echo $apiData['city_name'] ?? 'Неизвестно'; ?></td>
        <td><?php echo $visit['user_agent']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>