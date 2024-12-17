<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School ID Printing System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .nav-button {
            display: block;
            background-color: #001d7d;
            color: #ffffff;
            padding: 12px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 1em;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s;
        }

        .nav-button:hover {
            background-color: #003399;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>School ID Printing System</h1>
        <a href="student_registration.php" class="nav-button">Add Student Details</a>
        <a href="view_students.php" class="nav-button">View Students</a>
        <a href="image_capture.php" class="nav-button">Capture Student Image</a>
        <a href="id_card.php" class="nav-button">Generate ID Card</a>
    </div>
</body>
</html>
