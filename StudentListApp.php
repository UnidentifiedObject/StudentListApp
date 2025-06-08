<?php

$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername,$username,$password,$dbname);

$editNumber = null;
$editName = null;

if (isset($_POST['edit'])) {
    $editNumber = $_POST['edit_number'];
    
    $stmt = $conn->prepare("SELECT number, names FROM students WHERE number = ?");
    $stmt->bind_param("i", $editNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row) {
        $editNumber = $row['number'];
        $editName = $row['names'];
    }
    $stmt->close();
}

if (isset($_POST['update'])) {
    $numara = $_POST['number'];
    $isim = $_POST['names'];

    if (!filter_var($numara, FILTER_VALIDATE_INT)) {
        $error = "Invalid student number.";
    } else {
        $stmt = $conn->prepare("UPDATE students SET names = ? WHERE number = ?");
        $stmt->bind_param("si", $isim, $numara);
        $stmt->execute();
        $stmt->close();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_POST['cancel'])) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


//Insert
if (isset($_POST['submit'])) {
    $numara = $_POST['number'];
    $isim = $_POST['names'];
    $sorgu = $conn->prepare("INSERT INTO students (number, names) VALUES (?, ?) ");
    $sorgu->bind_param("is", $numara, $isim );
    $sorgu->execute(); 

     // Redirect after deletion
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// DELETE - Delete user
if (isset($_POST['delete'])) {
    $numaraSil = $_POST['number'];
    $stmt = $conn->prepare("DELETE FROM students WHERE number =?");
    $stmt->bind_param("i", $numaraSil);
    $stmt->execute();
    $stmt->close();

     // Redirect after deletion
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$searchedStudent = null;
$searchError = '';

if (isset($_POST['search'])) {
    $searchNumber = $_POST['search_number'];

    if (!filter_var($searchNumber, FILTER_VALIDATE_INT)) {
        $searchError = "Please enter a valid student number.";
    } else {
        $stmt = $conn->prepare("SELECT number, names FROM students WHERE number = ?");
        $stmt->bind_param("i", $searchNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        $searchedStudent = $result->fetch_assoc();
        $stmt->close();

        if (!$searchedStudent) {
            $searchError = "Student with number $searchNumber not found.";
        }
    }
}


// Fetch all students
$students = [];
$result = $conn->query("SELECT number, names FROM students");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Hello!</h2>
    
    <h3><?php echo isset($editNumber) ? "Edit Student" : "Add a New Student"; ?></h3>

<form method="POST">
    Enter Student number: 
    <input type="number" name="number" id="nmbr" max=8 required 
        value="<?php echo isset($editNumber) ? htmlspecialchars($editNumber) : ''; ?>"
        <?php echo isset($editNumber) ? 'readonly' : ''; ?> >
    <br><br>
    Enter Student name: 
    <input type="text" name="names" id="names" required
        value="<?php echo isset($editName) ? htmlspecialchars($editName) : ''; ?>">
    <br><br>

    <?php if (isset($editNumber)): ?>
        <input type="submit" name="update" value="Update Student">
        <input type="submit" name="cancel" value="Cancel">
    <?php else: ?>
        <input type="submit" name="submit" value="Add Student">
    <?php endif; ?>
</form>

    <h3>Delete a Student</h3>
    <form method="POST">
    Enter Student number to delete: 
    <input type="number" name="number" id="nmbr_delete" required> <br><br>
    <input type="submit" name="delete" value="Delete Student 🗑️"> <br><br>
    </form>

    <h3>Find a Student</h3>
  <form method="POST">
    Enter Student Number: 
    <input type="number" name="search_number" required>
    <input type="submit" name="search" value="Search">
  </form>

  <?php if (!empty($searchError)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($searchError); ?></p>
  <?php elseif ($searchedStudent): ?>
    <p><strong>Student Found:</strong></p>
    <ul>
        <li>Number: <?php echo htmlspecialchars($searchedStudent['number']); ?></li>
        <li>Name: <?php echo htmlspecialchars($searchedStudent['names']); ?></li>
    </ul>
  <?php endif; ?>



    <div class="table-wrapper">
        <p>Here is the list of current students:</p>
        <div class="scroll-table">
            <table border=1px>
        
              <tr>  
                  <th>
                    Student number
                  </th>  
                  <th>
                    Student name
                  </th>
                  <th>
                    Edit
                  </th>
                   <?php foreach ($students as $student): ?>
                    <tr>
                     <td><?php echo htmlspecialchars($student['number']); ?></td>
                     <td><?php echo htmlspecialchars($student['names']); ?></td>
                     <td>
                           <form method="POST" style="display:inline;">
                           <input type="hidden" name="edit_number" value="<?php echo $student['number']; ?>">
                           <input type="submit" name="edit" value="Edit">
                           </form>
                    </td>
                    </tr>

                    <?php endforeach; ?>
                
                </tr>

            </table>
        </div>
    </div>

</body>
</html>

