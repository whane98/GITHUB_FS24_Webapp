<?php
require_once 'config.php'; // DB-Verbindungsdaten aus externer Datei laden

// 0. Datenbankverbindung mit PDO herstellen

// 2. Einfügen eines neuen Datensatzes

// 3. Lesen eines Datensatzes mit id

// 4. Lesen aller Datensätze, die den String $string in firstname, lastname oder email enthalten

// 5. Delete mit email 

// 1. Abfrage aller Datensätze aus der Tabelle User

/*if ($json != "false") {
  echo $json;
} else {
  echo $jsonList;
}*/
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>PHP mit HTML</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1><a href="crud_direkt.php">CRUD - PHP</a></h1>


  <!-- 1. Ausgabe des Arras $users in einer Tabelle -->

  <!-- 2. Einfügen eines neuen Datensatzes -->

  <!-- 3. Lesen eines Datensatzes mit id -->

  <!-- 4. Lesen aller Datensätze, die den String $string in firstname, lastname oder email enthalten -->

  <!-- 5. Delete mit email -->

   <!-- 1. Abfrage aller Datensätze aus der Tabelle User-->
  <table>
    <tr>
      <th>ID</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
    </tr>
    <?php foreach ($users as $user) : ?>
      <tr>
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['firstname']; ?></td>
        <td><?php echo $user['lastname']; ?></td>
        <td><?php echo $user['email']; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

</body>

</html>