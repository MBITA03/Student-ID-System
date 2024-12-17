<?php
require 'dbconfig.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Students</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
        }
        .search-container {
            margin-bottom: 15px;
            text-align: center;
        }
        .search-container input {
            padding: 8px;
            width: 300px;
            font-size: 1em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
    <script>
        function searchTable() {
            // Get the value from the search input
            let input = document.getElementById("searchInput").value.toUpperCase();
            let table = document.getElementById("studentTable");
            let tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those that don't match the search query
            for (let i = 1; i < tr.length; i++) {
                let tdFirstName = tr[i].getElementsByTagName("td")[1];
                let tdLastName = tr[i].getElementsByTagName("td")[2];
                let tdExamNo = tr[i].getElementsByTagName("td")[0];
                
                if (tdFirstName || tdLastName || tdExamNo) {
                    let firstName = tdFirstName.textContent || tdFirstName.innerText;
                    let lastName = tdLastName.textContent || tdLastName.innerText;
                    let examNo = tdExamNo.textContent || tdExamNo.innerText;
                    
                    if (firstName.toUpperCase().indexOf(input) > -1 || 
                        lastName.toUpperCase().indexOf(input) > -1 || 
                        examNo.toUpperCase().indexOf(input) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</head>
<body>

<h2>Student Records</h2>
<a href="index.php" class="btn btn-outline-primary mb-3">Home</a>
<div class="search-container">
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by Exam No, First Name, or Last Name">
</div>

<table id="studentTable">
    <thead>
        <tr>
            <th>Exam No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Sex</th>
            <th>Photo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Retrieve student records
        $sql = "SELECT exam_no, first_name, last_name, dob, sex, photo FROM students";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['exam_no']) . "</td>";
                echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
                echo "<td>" . htmlspecialchars($row['sex']) . "</td>";
                echo "<td>";
                
                // Display photo if available
                if (!empty($row['photo']) && file_exists($row['photo'])) {
                    echo "<img src='" . htmlspecialchars($row['photo']) . "' alt='Student Photo' style='width:50px; height:60px;'>";
                } else {
                    echo "No Photo";
                }
                
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found.</td></tr>";
        }

        // Close db connect
        $conn->close();
        ?>
    </tbody>
</table>

</body>
</html>
