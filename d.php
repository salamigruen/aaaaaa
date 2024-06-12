<!DOCTYPE php>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="images/x-icon" href="logo.png">
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
        body {
            margin: 0;
            padding: 0;
            font-family: "Roboto", sans-serif;
            background-color: #f0f2f5;
            display: flex;
        }
        header {
            background-color: #8B0000;
            padding: 10px 20px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header-title {
            font-size: 24px;
            font-weight: 700;
        }
        .Btn {
            background-color: #fff;
            color: #8B0000;
            border: 1px solid #8B0000;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .Btn:hover {
            background-color: #8B0000;
            color: #fff;
        }
        .sidebar {
            width: 250px;
            background-color: #fff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            padding-top: 20px;
        }
        .sidebar a {
            text-decoration: none;
            color: #333;
            padding: 15px 20px;
            display: block;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #f4f4f4;
        }
        .container {
            flex-grow: 1;
            padding: 20px;
        }
        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            font-weight: 700;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        input[type="text"], button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        button {
            background-color: #8B0000;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #660000;
        }
        .act {
            color: #fff;
            background-color: #8B0000;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #333;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <header>
        <a href="panel.html"><button class="Btn"><i class='bx bx-home-alt'></i>&nbsp; Admin Panel Overview</button></a>
    </header>
    <div class="sidebar">
        <a href="#fakultaets-daten">Fakultäts-Daten</a>
        <a href="#fakultaeten-bearbeiten">Fakultäten bearbeiten</a>
        <a href="#fakultaet-loeschen">Fakultät löschen</a>
        <a href="#neue-fakultaet-hinzufuegen">Neue Fakultät hinzufügen</a>
    </div>
    <div class="container">
        <h1 class="admin">Admin Panel</h1>
        <div class="content">
            <h2>Uni-Daten</h2>
            <div style="max-height: 400px; overflow-y: auto;">
                <table>
                    <tr>
                        <th>UNr</th>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Straße</th>               
                        <th>Hausnummer</th>
                        <th>Postleitzahl</th>
                        <th>Stadt</th>
                        <th>Bundesland</th>
                        <th>Gründungsjahr</th>
                    </tr>
                    <?php
                    $pdo = new PDO('mysql:host=localhost;dbname=uni', 'root', '');
                    $stmt = $pdo->query('SELECT * FROM universitaeten');
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['UNr']."</td>";
                        echo "<td>".$row['Name']."</td>";
                        echo "<td>".$row['EMail']."</td>";
                        echo "<td>".$row['Strasse']."</td>";
                        echo "<td>".$row['Hausnummer']."</td>";
                        echo "<td>".$row['PLZ']."</td>";
                        echo "<td>".$row['Stadt']."</td>";
                        echo "<td>".$row['Bundesland']."</td>";
                        echo "<td>".$row['Gruendungsjahr']."</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <form method="post">
                <button class="page_act" type="submit" name="refresh_page">Aktualisieren</button>
            </form>
        </div>
        <div class="content">
            <h2>Uni bearbeiten</h2>
            <form method="post">
                <input type="text" id="edit_id" name="edit_id" placeholder="UNr eingeben">
                <button type="submit" name="fetch_uni">Uni bearbeiten</button>
            </form>

            <?php
            if(isset($_POST['fetch_uni'])) {
                $edit_id = $_POST['edit_id'];
                $stmt = $pdo->prepare('SELECT * FROM universitaeten WHERE UNr = ?');
                $stmt->execute([$edit_id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <form method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $row['UNr']; ?>">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['Name']; ?>"><br>
                    <label for="email">E-Mail:</label>
                    <input type="text" id="email" name="email" value="<?php echo $row['EMail']; ?>"><br>
                    <label for="street">Strasse:</label>
                    <input type="text" id="street" name="street" value="<?php echo $row['Strasse']; ?>"><br>
                    <label for="number">Hausnummer:</label>
                    <input type="text" id="number" name="number" value="<?php echo $row['Hausnummer']; ?>"><br>
                    <label for="zip">Postleitzahl:</label>
                    <input type="text" id="zip" name="zip" value="<?php echo $row['PLZ']; ?>"><br>
                    <label for="city">Stadt:</label>
                    <input type="text" id="city" name="city" value="<?php echo $row['Stadt']; ?>"><br>
                    <label for="state">Bundesland:</label>
                    <input type="text" id="state" name="state" value="<?php echo $row['Bundesland']; ?>"><br>
                    <label for="year">Gründungsjahr:</label>
                    <input type="text" id="year" name="year" value="<?php echo $row['Gruendungsjahr']; ?>"><br>
                    <button type="submit" name="update_uni">Uni aktualisieren</button>
                </form>
            <?php } ?>

            <?php
            if(isset($_POST['update_uni'])) {
                $update_id = $_POST['edit_id'];
                $stmt = $pdo->prepare('UPDATE universitaeten SET Name=?, EMail=?, Strasse=?, Hausnummer=?, PLZ=?, Stadt=?, Bundesland=?, Gruendungsjahr=? WHERE UNr=?');
                $stmt->execute([$_POST['name'], $_POST['email'], $_POST['street'], $_POST['number'], $_POST['zip'], $_POST['city'], $_POST['state'], $_POST['year'], $update_id]);
                echo "<p class='act'>Uni-Daten aktualisiert!</p>";
            }
            ?>
        </div>
        <div class="content">
            <h2>Uni löschen</h2>
            <form method="post">
                <input type="text" id="delete_id" name="delete_id" placeholder="UNr eingeben">
                <button type="submit" name="delete_uni" class="btn-del">Uni löschen</button>
            </form>

            <?php
            if(isset($_POST['delete_uni'])) {
                $delete_id = $_POST['delete_id'];
                $stmt = $pdo->prepare('DELETE FROM universitaeten WHERE UNr = ?');
                $stmt->execute([$delete_id]);
                echo "<p class='act'>Uni gelöscht!</p>";
            }
            ?>
        </div>
        <div class="content">
            <h2>Neue Uni hinzufügen</h2>
            <form method="post">
                <input type="text" id="new_name" name="new_name" placeholder="Name"><br>
                <input type="text" id="new_email" name="new_email" placeholder="E-Mail"><br>
                <input type="text" id="new_street" name="new_street" placeholder="Straße"><br>
                <input type="text" id="new_number" name="new_number" placeholder="Hausnummer"><br>
                <input type="text" id="new_zip" name="new_zip" placeholder="PLZ"><br>
                <input type="text" id="new_city" name="new_city" placeholder="Stadt"><br>
                <input type="text" id="new_state" name="new_state" placeholder="Bundesland"><br>
                <input type="text" id="new_year" name="new_year" placeholder="Gründungsjahr"><br>
                <button type="submit" name="add_uni">Uni hinzufügen</button>
            </form>

            <?php
            if(isset($_POST['add_uni'])) {
                $stmt = $pdo->prepare('INSERT INTO universitaeten (Name, EMail, Strasse, Hausnummer, PLZ, Stadt, Bundesland, Gruendungsjahr) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$_POST['new_name'], $_POST['new_email'], $_POST['new_street'], $_POST['new_number'], $_POST['new_zip'], $_POST['new_city'], $_POST['new_state'], $_POST['new_year']]);
                echo "<p class='act'>Neue Uni hinzugefügt!</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
