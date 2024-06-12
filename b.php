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
            <h2>Studiengang-Daten</h2>
            <div style="max-height: 400px; overflow-y: auto;">
                <table>
                    <tr>
                        <th>SNr</th>
                        <th>Studiengang</th>
                        <th>Studieninhalte</th>
                        <th>Berufsmoeglichkeiten</th>               
                        <th>Zulassungsbeschraenkungen</th>
                    </tr>
                    <?php
                    $pdo = new PDO('mysql:host=localhost;dbname=uni', 'root', '');
                    $stmt = $pdo->query('SELECT * FROM studiengang');
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['SNr']."</td>";
                        echo "<td>".$row['Studiengang']."</td>";
                        echo "<td>".$row['Studieninhalte']."</td>";
                        echo "<td>".$row['Berfusmoeglichkeiten']."</td>";
                        echo "<td>".$row['Zuassungsbeschraenkungen']."</td>";
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
            <h2>Studiengang bearbeiten</h2>
            <form method="post">
                <input type="text" id="edit_id" name="edit_id" placeholder="SNr eingeben">
                <button type="submit" name="fetch_sgang">Studiengang bearbeiten</button>
            </form>

            <?php
            if(isset($_POST['fetch_sgang'])) {
                $edit_id = $_POST['edit_id'];
                $stmt = $pdo->prepare('SELECT * FROM studiengang WHERE SNr = ?');
                $stmt->execute([$edit_id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <form method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $row['SNr']; ?>">
                    <label for="course">Studiengang:</label>
                    <input type="text" id="course" name="course" value="<?php echo $row['Studiengang']; ?>"><br>
                    <label for="topic">Studieninhalte:</label>
                    <input type="text" id="topic" name="topic" value="<?php echo $row['Studieninhalte']; ?>"><br>
                    <label for="job">Berufsmoeglichkeiten:</label>
                    <input type="text" id="job" name="job" value="<?php echo $row['Berufsmoeglichkeiten']; ?>"><br>
                    <label for="require">Zulassungsbeschraenkungen:</label>
                    <input type="text" id="require" name="require" value="<?php echo $row['Zulassungsbeschraenkungen']; ?>"><br>
                    <button type="submit" name="update_sgang">Studiengang aktualisieren</button>
                </form>
            <?php } ?>

            <?php
            if(isset($_POST['update_sgang'])) {
                $update_id = $_POST['edit_id'];
                $stmt = $pdo->prepare('UPDATE studiengang SET Studiengang=?, Studieninhalte=?, Berufsmoeglichkeiten=?, Zulassungsbeschraenkungen=? WHERE SNr=?');
                $stmt->execute([$_POST['course'], $_POST['topic'], $_POST['job'], $_POST['require'], $update_id]);
                echo "<p class='act'>Studiengang-Daten aktualisiert!</p>";
            }
            ?>
        </div>
        <div class="content">
            <h2>Studiengang löschen</h2>
            <form method="post">
                <input type="text" id="delete_id" name="delete_id" placeholder="SNr eingeben">
                <button type="submit" name="delete_sgang" class="btn-del">Studiengang löschen</button>
            </form>

            <?php
            if(isset($_POST['delete_sgang'])) {
                $delete_id = $_POST['delete_id'];
                $stmt = $pdo->prepare('DELETE FROM studiengang WHERE SNr = ?');
                $stmt->execute([$delete_id]);
                echo "<p class='act'>Studiengang gelöscht!</p>";
            }
            ?>
        </div>
        <div class="content">
            <h2>Neuen Studiengang hinzufügen</h2>
            <form method="post">
                <input type="text" id="new_course" name="new_course" placeholder="Studiengang"><br>
                <input type="text" id="new_topic" name="new_topic" placeholder="Studieninhalte"><br>
                <input type="text" id="new_job" name="new_job" placeholder="Berufsmoeglichkeiten"><br>
                <input type="text" id="new_require" name="new_require" placeholder="Zulassungsbeschraenkungen"><br>
                <button type="submit" name="add_sgang">Stuidengang hinzufügen</button>
            </form>

            <?php
            if(isset($_POST['add_sgang'])) {
                $stmt = $pdo->prepare('INSERT INTO studiengang (Studiengang, Studieninhalte, Berufsmoeglichkeiten, Zulassungsbeschraenkungen) VALUES (?, ?, ?, ?)');
                $stmt->execute([$_POST['new_course'], $_POST['new_topic'], $_POST['new_job'], $_POST['new_require']]);
                echo "<p class='act'>Neuen Studiengang hinzugefügt!</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
