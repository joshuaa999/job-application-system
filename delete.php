
<?php
require_once "dbconfig.php";

if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) {
    header("Location: display_table.php");
    exit;
}

$id = (int) $_GET["id"];

// Retrieve the selected application.
$stmt = $pdo->prepare(
    "SELECT * FROM job_applications WHERE application_id = :id"
);
$stmt->execute(["id" => $id]);
$application = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$application) {
    header("Location: display_table.php");
    exit;
}

// Delete the record only after the user confirms.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare(
        "DELETE FROM job_applications WHERE application_id = :id"
    );
    $stmt->execute(["id" => $id]);

    header("Location: display_table.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Application | Job Application System</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f6f4;
            color: #26352d;
        }

        header {
            background: #173f35;
            color: white;
            padding: 25px 6%;
        }

        header h1 {
            margin: 0 0 7px;
        }

        header p {
            margin: 0;
            color: #d5e5dc;
        }

        main {
            max-width: 800px;
            width: 92%;
            margin: 30px auto;
        }

        .panel {
            background: white;
            padding: 25px;
            border: 1px solid #e1e9e3;
            border-radius: 12px;
        }

        .warning {
            padding: 15px;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .details {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        .details th, .details td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #e1e9e3;
            vertical-align: top;
        }

        .details th {
            width: 35%;
            background: #edf3ef;
        }

        .button-row {
            display: flex;
            gap: 10px;
        }

        button, .back-link {
            display: inline-block;
            padding: 11px 16px;
            border: none;
            border-radius: 6px;
            font: inherit;
            text-decoration: none;
            cursor: pointer;
        }

        button {
            background: #dc2626;
            color: white;
        }

        .back-link {
            background: #e5e7eb;
            color: #26352d;
        }
    </style>
</head>

<body>

<header>
    <h1>Job Application System</h1>
    <p>Delete Applicant Record</p>
</header>

<main>
    <section class="panel">
        <h2>Delete Application #<?= htmlspecialchars((string) $id) ?></h2>

        <div class="warning">
            Are you sure you want to delete this application? This action cannot be undone.
        </div>

        <table class="details">
            <tr>
                <th>First Name</th>
                <td><?= htmlspecialchars($application['first_name']) ?></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><?= htmlspecialchars($application['last_name']) ?></td>
            </tr>
            <tr>
                <th>Position Applied</th>
                <td><?= htmlspecialchars($application['position_applied']) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($application['email']) ?></td>
            </tr>
        </table>

        <form method="POST" action="delete.php?id=<?= urlencode((string) $id) ?>">
            <div class="button-row">
                <button type="submit">Confirm Delete</button>
                <a class="back-link" href="display_table.php">Cancel</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>
