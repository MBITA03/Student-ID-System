<?php
require 'dbconfig.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate ID Card</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
        }
        #idCard {
            width: 3.6in;
            height: 2in;
            border: 3px solid #000;
            padding: 10px;
            background-color: #f9f9f9;
            position: relative;
            color: #000;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
            margin-left: 5px;
            margin-top: 10px;
        }
        
        /* Header Styles */
        #header {
            background-color: #001d7d;
            color: #ffffff;
            text-align: center;
            padding: 3px;
            font-size: 0.7em;
            font-weight: bold;
        }

        #subHeader {
            text-align: center;
            font-size: 0.6em;
            margin-top: 5px;
        }

        /* ID Content */
        #content {
            display: flex;
            padding-top: 5px;
        }

        #details {
            font-size: 0.9em;
            line-height: 1.2;
            flex: 1;
            padding-right: 10px;
        }
        
        #details .name {
            font-size: 0.9em;
            font-weight: bold;
            color: #d32f2f;
            margin-bottom: 3px;
        }

        #photo {
            width: 1in;
            height: 1.1in;
            border: 1px solid #000;
            display: inline-block;
            margin-bottom: 10px;
        }

        /* Footer Section */
        #footer {
            background-color: #f9a825;
            text-align: center;
            font-size: 0.6em;
            padding: 1px;
            position: absolute;
            bottom: 0;
            width: 90%;
            color: #000;
        }
    </style>
</head>
<body>
    <h2>Generate Student ID Card</h2>
    <a href="index.php " class="btn btn-outline-primary mb-3">Home</a>
    <form action="id_card.php" method="GET">
        <label for="exam_no_print">Enter Exam No:</label>
        <input type="text" id="exam_no_print" name="exam_no_print" required><br>
        <button type="submit">Generate ID</button>
    </form>

    <?php
        if (isset($_GET['exam_no_print'])) {
            $exam_no = $_GET['exam_no_print'];
    
            $sql = "SELECT exam_no, first_name, last_name, dob, sex, photo FROM students WHERE exam_no = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $exam_no);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<div id="idCard">';
                echo '<div id="header">KAPIRI MPOSHI COMMUNITY SCHOOL</div>';
                
                echo '<div id="subHeader">GRADE TWELVE ID CARD</div>';
    
                echo '<div id="content">';
                
                echo '<div id="details">';
                echo '<div class="name">'.'<p> Name:  ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) .'</p>'. '</div>';
                echo '<p>Exam No: ' . htmlspecialchars($row['exam_no']) . '</p>';
                echo '<p>DOB: ' . htmlspecialchars($row['dob']) . '</p>';
                echo '<p>Sex: ' . htmlspecialchars($row['sex']) . '</p>';
                echo '</div>';
                
                echo '<div id="photo">';
                // Display the photo
                if (!empty($row['photo']) && file_exists($row['photo'])) {
                    echo '<img src="' . htmlspecialchars($row['photo']) . '" alt="Student Photo" style="width:100%; height:100%;">';
                } else {
                    echo '<p>Student Photo</p>';
                }
                echo '</div>';
    
                echo '</div>';  // End of content
    
                echo '<div id="footer">Motto: Rise and Shine</div>';
                echo '</div>';
            } else {
                echo "No student found with that Exam No.";
            }
    
            $stmt->close();
            $conn->close();
        }

    ?>

</body>
</html>
