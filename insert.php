
<?php
require_once "dbconfig.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "INSERT INTO job_applications
            (first_name, last_name, position_applied, email, phone_number,
             educational_attainment, technical_skills, years_of_experience)
            VALUES
            (:first_name, :last_name, :position_applied, :email, :phone_number,
             :educational_attainment, :technical_skills, :years_of_experience)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "first_name" => trim($_POST["first_name"]),
        "last_name" => trim($_POST["last_name"]),
        "position_applied" => trim($_POST["position_applied"]),
        "email" => trim($_POST["email"]),
        "phone_number" => trim($_POST["phone_number"]),
        "educational_attainment" => trim($_POST["educational_attainment"]),
        "technical_skills" => trim($_POST["technical_skills"]),
        "years_of_experience" => (int) $_POST["years_of_experience"]
    ]);

    header("Location: display_table.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Application | Job Application System</title>

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
    <p>Data Analyst Job Application Form</p>
</header>

<main>
    <section class="panel">
        <h2>Submit a Job Application</h2>
        <p>Enter the applicant's information below.</p>

        <form method="POST" action="insert.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>

                <div class="form-group">
                    <label for="position_applied">Position Applied</label>
                    <input type="text" id="position_applied" name="position_applied"
                           value="Data Analyst" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="tel" id="phone_number" name="phone_number" required>
                </div>

                <div class="form-group">
                    <label for="educational_attainment">Educational Attainment</label>
                    <select id="educational_attainment" name="educational_attainment" required>
                        <option value="">Select education level</option>
                        <option value="Senior High School">Senior High School</option>
                        <option value="Undergraduate">Undergraduate</option>
                        <option value="Bachelor's Degree">Bachelor's Degree</option>
                        <option value="Master's Degree">Master's Degree</option>
                        <option value="Doctorate">Doctorate</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="technical_skills">Technical Skills</label>
                    <textarea id="technical_skills" name="technical_skills"
                              placeholder="e.g. SQL, Excel, Python, Power BI" required></textarea>
                </div>

                <div class="form-group">
                    <label for="years_of_experience">Years of Experience</label>
                    <input type="number" id="years_of_experience"
                           name="years_of_experience" min="0" value="0" required>
                </div>
            </div>

            <div class="button-row">
                <button type="submit">Submit Application</button>
                <a class="back-link" href="display_table.php">Back to Applications</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>
