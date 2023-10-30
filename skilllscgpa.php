<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .skills {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .skills form {
            text-align: center;
        }

        .skills input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .skills button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .skills button:hover {
            background-color: #45a049;
        }
        
        .resume-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .resume-table th,
        .resume-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        .resume-table th {
            background-color: black;
            color: white;
        }
        
        .resume-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .resume-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .no-records {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 24px;
            color: #ff5555;
            text-align: center;
            padding: 20px;
            background-color: #ffe6e6;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="skills">
        <h2>Filter by Skills, CGPA, Experience, and Degrees</h2>
        <form action="skilllscgpa.php" method="GET">
            <input type="text" name="skills" placeholder="Enter skill">
            <input type="number" name="cgpa" step="0.01" placeholder="Enter CGPA">
            <input type="number" name="experience" placeholder="Enter Experience">
            <input type="text" name="degrees" placeholder="Enter Degrees">
            <button type="submit">Filter</button>
        </form>
    </div>

    <?php
    error_reporting(E_ERROR | E_PARSE);
    if (isset($_GET['skills']) || isset($_GET['cgpa']) || isset($_GET['experience']) || isset($_GET['degrees'])) {
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "resumefields";

        // Create a new connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL statement
        $sql = "SELECT * FROM resumes WHERE 1=1";
        $params = array();
        
        // Handle the skills filter
        if (isset($_GET['skills']) && !empty($_GET['skills'])) {
            $skillsFilter = $_GET['skills'];
            $skillsArray = explode(',', $skillsFilter);
            $conditions = array_fill(0, count($skillsArray), "skills LIKE ?");
            $skillsConditions = implode(' OR ', $conditions);
            $sql .= " AND ($skillsConditions)";
            $params = array_merge($params, $skillsArray);
        }
        
        // Handle the CGPA filter
        if (isset($_GET['cgpa']) && !empty($_GET['cgpa'])) {
            $cgpaFilter = $_GET['cgpa'];
            $sql .= " AND cgpa > ?";
            $params[] = $cgpaFilter;
        }

        // Handle the Experience filter
        if (isset($_GET['experience']) && !empty($_GET['experience'])) {
            $experienceFilter = $_GET['experience'];
            $sql .= " AND experience > ?";
            $params[] = $experienceFilter;
        }

        // Handle the Degrees filter
        if (isset($_GET['degrees']) && !empty($_GET['degrees'])) {
            $degreesFilter = $_GET['degrees'];
            $sql .= " AND degrees LIKE ?";
            $params[] = '%' . $degreesFilter . '%';
        }

        // Prepare the statement
        $stmt = $conn->prepare($sql);
        $paramTypes = str_repeat('s', count($params));
        $stmt->bind_param($paramTypes, ...$params);
        
        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Check if there are any records
        if ($result->num_rows > 0) {
            echo "<table class='resume-table'>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Profession</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>About Me</th>
                        <th>Experience</th>
                        <th>Skills</th>
                        <th>Degrees</th>
                        <th>CGPA</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['first_name'] . "</td>
                        <td>" . $row['last_name'] . "</td>
                        <td>" . $row['profession'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['phone'] . "</td>
                        <td>" . $row['about_me'] . "</td>
                        <td>" . $row['experience'] . "</td>
                        <td>" . $row['skills'] . "</td>
                        <td>" . $row['degrees'] . "</td>
                        <td>" . $row['cgpa'] . "</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo '<p class="no-records">No records found.</p>';
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
