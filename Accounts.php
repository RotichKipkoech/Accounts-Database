// Database connection parameters
    $servername = "your_server_name";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database_name";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Fetch student data from the database
    $result = $conn->query("SELECT * FROM students");

    if ($result->num_rows > 0) {
      // Display dropdown to select a student
      echo "<form method='post'>";
      echo "<label for='student_id'>Select Student:</label>";
      echo "<select name='student_id'>";
      while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['StudentID']}'>{$row['Name']}</option>";
      }
      echo "</select>";
      echo "<input type='submit' name='refresh_btn' value='Refresh'>";
      echo "</form>";

      // Display fees information in a table
      if (isset($_POST['student_id'])) {
        $selectedStudentID = $_POST['student_id'];
        $feesResult = $conn->query("SELECT * FROM students WHERE StudentID = $selectedStudentID");
        
        echo "<h2>Fees Information</h2>";
        echo "<table>";
        echo "<tr><th>StudentID</th><th>Name</th><th>FeesPaid</th><th>TotalFees</th></tr>";
        
        while ($feesRow = $feesResult->fetch_assoc()) {
          echo "<tr><td>{$feesRow['StudentID']}</td><td>{$feesRow['Name']}</td><td>{$feesRow['FeesPaid']}</td><td>{$feesRow['TotalFees']}</td></tr>";
        }
        
        echo "</table>";
      }
     else {
      echo "No students found in the database.";
    }
    // Close the database connection
    $conn->close();
