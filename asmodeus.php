<!DOCTYPE php>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
        <a href="panel.html"><button class="Btn">Admin Panel Overview</button></a>
    </header>
    <div class="sidebar">
        <a href="#fakultaets-daten">Fakultäts-Daten</a>
        <a href="#fakultaeten-bearbeiten">Fakultäten bearbeiten</a>
        <a href="#fakultaet-loeschen">Fakultät löschen</a>
        <a href="#neue-fakultaet-hinzufuegen">Neue Fakultät hinzufügen</a>
    </div>
    <div class="container">
        <div id="fakultaets-daten" class="card">
            <h2>Fakultäts-Daten</h2>
            <div style="max-height: 400px; overflow-y: auto;">
                <table>
                    <tr>
                        <th>FNr</th>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Strasse</th>               
                        <th>HausNr</th>
                        <th>UNr</th>
                    </tr>
                    <?php
                    $pdo = new PDO('mysql:host=localhost;dbname=uni', 'root', '');
                    $stmt = $pdo->query('SELECT * FROM fakultaeten');
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['FNr']."</td>";
                        echo "<td>".$row['Name']."</td>";
                        echo "<td>".$row['E-Mail']."</td>";
                        echo "<td>".$row['Strasse']."</td>";
                        echo "<td>".$row['HausNr']."</td>";
                        echo "<td>".$row['UNr']."</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <form method="post">
                <button type="submit" name="refresh_page">Aktualisieren</button>
            </form>
        </div>
        <div id="fakultaeten-bearbeiten" class="card">
            <h2>Fakultäten bearbeiten</h2>
            <form method="post">
                <input type="text" id="edit_id" name="edit_id" placeholder="FNr eingeben">
                <button type="submit" name="fetch_faku">Fakultät bearbeiten</button>
            </form>

            <?php
            if(isset($_POST['fetch_faku'])) {
                $edit_id = $_POST['edit_id'];
                $stmt = $pdo->prepare('SELECT * FROM fakultaeten WHERE FNr = ?');
                $stmt->execute([$edit_id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <form method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $row['FNr']; ?>">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['Name']; ?>"><br>
                    <label for="mail">E-Mail:</label>
                    <input type="text" id="mail" name="mail" value="<?php echo $row['E-Mail']; ?>"><br>
                    <label for="street">Strasse:</label>
                    <input type="text" id="street" name="street" value="<?php echo $row['Strasse']; ?>"><br>
                    <label for="number">HausNr:</label>
                    <input type="text" id="number" name="number" value="<?php echo $row['HausNr']; ?>"><br>
                    <label for="uni">UNr:</label>
                    <input type="text" id="uni" name="uni" value="<?php echo $row['UNr']; ?>"><br>
                    <button type="submit" name="update_faku">Fakultät aktualisieren</button>
                </form>
            <?php } ?>

            <?php
            if(isset($_POST['update_faku'])) {
                $update_id = $_POST['edit_id'];
                $stmt = $pdo->prepare('UPDATE fakultaeten SET Name=?, E-Mail=?, Strasse=?, HausNr=?, UNr=? WHERE FNr=?');
                $stmt->execute([$_POST['name'], $_POST['mail'], $_POST['street'], $_POST['number'], $_POST['uni'], $update_id]);
                echo "<p class='act'>Fakultäts-Daten aktualisiert!</p>";
            }
            ?>
        </div>
        <div id="fakultaet-loeschen" class="card">
            <h2>Fakultät löschen</h2>
            <form method="post">
                <input type="text" id="delete_id" name="delete_id" placeholder="FNr eingeben">
                <button type="submit" name="delete_faku" class="btn-del">Fakultät löschen</button>
            </form>

            <?php
            if(isset($_POST['delete_faku'])) {
                $delete_id = $_POST['delete_id'];
                $stmt = $pdo->prepare('DELETE FROM fakultaeten WHERE FNr = ?');
                $stmt->execute([$delete_id]);
                echo "<p class='act'>Fakultät gelöscht!</p>";
            }
            ?>
        </div>
        <div id="neue-fakultaet-hinzufuegen" class="card">
            <h2>Neue Fakultät hinzufügen</h2>
            <form method="post">
                <input type="text" id="new_name" name="new_name" placeholder="Name"><br>
                <input type="text" id="new_mail" name="new_mail" placeholder="E-Mail"><br>
                <input type="text" id="new_street" name="new_street" placeholder="Strasse"><br>
                <input type="text" id="new_number" name="new_number" placeholder="HausNr"><br>
                <input type="text" id="new_uni" name="new_uni" placeholder="UNr"><br>
                <button type="submit" name="add_faku">Neue Fakultät hinzufügen</button>
            </form>

            <?php
            if(isset($_POST['add_faku'])) {
                $stmt = $pdo->prepare('INSERT INTO fakultaeten (Name, E-Mail, Strasse, HausNr, UNr) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([$_POST['new_name'], $_POST['new_mail'], $_POST['new_street'], $_POST['new_number'], $_POST['new_uni']]);
                echo "<p class='act'>Neue Fakultät hinzugefügt!</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
