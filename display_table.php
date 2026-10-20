
<?php
require_once "dbconfig.php";

// Retrieve all job applications from the database.
$sql = "SELECT * FROM job_applications ORDER BY application_id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application System</title>

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
            max-width: 1200px;
            width: 92%;
            margin: 30px auto;
        }

        .panel {
            background: white;
            padding: 25px;
            border: 1px solid #e1e9e3;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .top-link {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            margin-bottom: 15px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #e1e9e3;
            vertical-align: top;
        }

        th {
            background: #edf3ef;
        }

        .action-link {
            margin-right: 8px;
            color: #2563eb;
            text-decoration: none;
        }

        .delete-link {
            color: #dc2626;
        }

        .empty-message {
            padding: 15px;
            background: #f3f6f4;
            border-radius: 6px;
        }
    </style>
</head>

<body>

<header>
    <h1>Job Application System</h1>
    <p>Manage Data Analyst job applications</p>
</header>

<main>
    <section class="panel">
        <h2>Job Applications</h2>
        <p>View all submitted applications and manage their records.</p>

        <a class="top-link" href="insert.php">+ Add New Application</a>

        <?php if (count($applications) > 0): ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Position Applied</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Education</th>
                            <th>Technical Skills</th>
                            <th>Experience</th>
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($applications as $application): ?>
                            <tr>
                                <td><?= htmlspecialchars($application['application_id']) ?></td>
                                <td><?= htmlspecialchars($application['first_name']) ?></td>
                                <td><?= htmlspecialchars($application['last_name']) ?></td>
                                <td><?= htmlspecialchars($application['position_applied']) ?></td>
                                <td><?= htmlspecialchars($application['email']) ?></td>
                                <td><?= htmlspecialchars($application['phone_number']) ?></td>
                                <td><?= htmlspecialchars($application['educational_attainment']) ?></td>
                                <td><?= htmlspecialchars($application['technical_skills']) ?></td>
                                <td><?= htmlspecialchars($application['years_of_experience']) ?></td>
                                <td><?= htmlspecialchars($application['date_added']) ?></td>
                                <td>
                                    <a class="action-link"
                                       href="update.php?id=<?= urlencode($application['application_id']) ?>">
                                        Update
                                    </a>

                                    <a class="action-link delete-link"
                                       href="delete.php?id=<?= urlencode($application['application_id']) ?>">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="empty-message">No job applications have been submitted yet.</p>
        <?php endif; ?>
    </section>
</main>

</body>
</html>
