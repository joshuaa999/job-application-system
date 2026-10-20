
<?php
require_once "dbconfig.php";

if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) {
    header("Location: display_table.php");
    exit;
}

$id = (int) $_GET["id"];
$message = "";

// Update the application when the form is submitted.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "UPDATE job_applications SET
                first_name = :first_name,
                last_name = :last_name,
                position_applied = :position_applied,
                email = :email,
                phone_number = :phone_number,
                educational_attainment = :educational_attainment,
                technical_skills = :technical_skills,
                years_of_experience = :years_of_experience
            WHERE application_id = :application_id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "first_name" => trim($_POST["first_name"]),
        "last_name" => trim($_POST["last_name"]),
        "position_applied" => trim($_POST["position_applied"]),
        "email" => trim($_POST["email"]),
        "phone_number" => trim($_POST["phone_number"]),
        "educational_attainment" => trim($_POST["educational_attainment"]),
        "technical_skills" => trim($_POST["technical_skills"]),
        "years_of_experience" => (int) $_POST["years_of_experience"],
        "application_id" => $id
    ]);

    header("Location: display_table.php");
    exit;
}

// Retrieve the selected application.
$stmt = $pdo->prepare(
    "SELECT * FROM job_applications WHERE application_id = :id"
);
$stmt->execute(["id" => $id]);
$application = $stmt->fetch(PDO::FETCH_ASSOC);

// Return to the table if the record doesn't exist.
if (!$application) {
    header("Location: display_table.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Application | Job Application System</title>

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
            max-width: 850px;
            width: 92%;
            margin: 30px auto;
        }

        .panel {
            background: white;
            padding: 25px;
            border: 1px solid #e1e9e3;
            border-radius: 12px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        label {
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5ce;
            border-radius: 6px;
            font: inherit;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        .button-row {
            display: flex;
            gap: 10px;
            margin-top: 22px;
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
            background: #2563eb;
            color: white;
        }

        .back-link {
            background: #e5e7eb;
            color: #26352d;
        }

        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

<header>
    <h1>Job Application System</h1>
    <p>Update Applicant Information</p>
</header>

<main>
    <section class="panel">
        <h2>Update Application #<?= htmlspecialchars((string) $id) ?></h2>
        <p>Edit the fields below and save your changes.</p>

        <form method="POST" action="update.php?id=<?= urlencode((string) $id) ?>">
            <div class="form-grid">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name"
                           value="<?= htmlspecialchars($application['first_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name"
                           value="<?= htmlspecialchars($application['last_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="position_applied">Position Applied</label>
                    <input type="text" id="position_applied" name="position_applied"
                           value="<?= htmlspecialchars($application['position_applied']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                           value="<?= htmlspecialchars($application['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="tel" id="phone_number" name="phone_number"
                           value="<?= htmlspecialchars($application['phone_number']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="educational_attainment">Educational Attainment</label>
                    <select id="educational_attainment" name="educational_attainment" required>
                        <?php
                        $educationOptions = [
                            "Senior High School",
                            "Undergraduate",
                            "Bachelor's Degree",
                            "Master's Degree",
                            "Doctorate"
                        ];
                        foreach ($educationOptions as $education):
                        ?>
                            <option value="<?= htmlspecialchars($education) ?>"
                                <?= $application['educational_attainment'] === $education ? "selected" : "" ?>>
                                <?= htmlspecialchars($education) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="technical_skills">Technical Skills</label>
                    <textarea id="technical_skills" name="technical_skills"
                              required><?= htmlspecialchars($application['technical_skills']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="years_of_experience">Years of Experience</label>
                    <input type="number" id="years_of_experience"
                           name="years_of_experience" min="0"
                           value="<?= htmlspecialchars((string) $application['years_of_experience']) ?>"
                           required>
                </div>
            </div>

            <div class="button-row">
                <button type="submit">Save Changes</button>
                <a class="back-link" href="display_table.php">Cancel</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>
