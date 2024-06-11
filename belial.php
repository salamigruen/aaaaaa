<!DOCTYPE php>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="images/x-icon" href="logo.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #ff4e50, #f9d423);
            color: white;
            overflow-x: hidden; 
        }
        header {
            display: flex;
            justify-content: center;
            background: rgba(0, 0, 0, 0.8);
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .Btn {
            display: inline-block;
            outline: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            line-height: 16px;
            padding: 10px 16px;
            min-width: 150px;
            border: none;
            color: #fff;
            background-color: #f95959;
            transition: background-color .17s ease, color .17s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .Btn:hover {
            background-color: #ff0000;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }
        h1, h2 {
            color: #ffffff;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .content {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            text-align: left;
        }
        th {
            background-color: rgba(0, 0, 0, 0.5);
            position: sticky;
            top: 0;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: calc(100% - 16px);
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.8);
            color: #333;
        }
        button {
            padding: 10px 20px;
            background-color: #f95959;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color .17s ease, color .17s ease;
        }
        button:hover {
            background-color: #ff0000;
        }
        .btn-del {
            background-color: #d9534f;
        }
        .admin {
            color: white;
        }
        .page_act {
            margin-top: 5px;
        }
        .act {
            color: white;
            font-weight: bold;
            background: rgba(255, 255, 255, 0.2);
            padding: 5px;
            border-radius: 5px;
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <a href="panel.html"><button class="Btn"><i class='bx bx-home-alt'></i>&nbsp; Admin Panel Overview</button></a>
    </header>
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
