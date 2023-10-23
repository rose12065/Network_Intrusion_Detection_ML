<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 
    <title>Document</title>
    <style>
         body{
            background-image: url(images/background.webp);
            background-repeat: no-repeat;
            background-size:auto;
        }
       .table_style{
        background-color:white;
       }
       .button {
    display: inline-block;
    padding: 10px 20px; /* Adjust padding to your liking */
    background-color: #3498db; /* Button background color */
    color: #ffffff; /* Button text color */
    text-decoration: none; /* Remove underline by default for links */
    border: none; /* Remove button border */
    border-radius: 4px; /* Rounded corners */
    cursor: pointer; /* Show a pointer cursor on hover */
    transition: background-color 0.3s, color 0.3s; /* Smooth transition on hover */
}

/* Hover effect - change background and text color */
.button:hover {
    background-color: #2980b9; /* New background color on hover */
    color: #ffffff; /* New text color on hover */
}

/* Additional styles for different button states (e.g., active, disabled) */
.button:active {
    background-color: #1c6ea4; /* Background color when button is clicked/active */
}

.button:disabled {
    background-color: #cccccc; /* Background color when button is disabled */
    color: #999999; /* Text color when button is disabled */
    cursor: not-allowed; /* Show a "not-allowed" cursor on disabled button */
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Network Intrusion Detection System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#resources">Resources</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#contact">Contact</a>
            </li>
        </ul>
    </div>
</nav>
<div class="table_style">

<?php
// Check if a file was uploaded
if (isset($_FILES['uploadFile']) && $_FILES['uploadFile']['error'] === UPLOAD_ERR_OK) {
    $uploadedFileName = $_FILES['uploadFile']['name'];
    $tempFilePath = $_FILES['uploadFile']['tmp_name'];

    $uploadDirectory = __DIR__ . '/data/';
    $targetFilePath = $uploadDirectory . $uploadedFileName;

    move_uploaded_file($tempFilePath, $targetFilePath); 

    } 
else {
    echo "Error: File upload failed or no file was uploaded.";
    }

$trainFilePath = "./data/" . $uploadedFileName;
//$testFilePath = "./data/Test_data.csv";

$trainData = [];
$testData = [];

if (($handle = fopen($trainFilePath, "r")) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        $trainData[] = $data;
    }
    fclose($handle);
}

// if (($handle = fopen($testFilePath, "r")) !== false) {
//     while (($data = fgetcsv($handle, 1000, ",")) !== false) {
//         $testData[] = $data;
//     }
//     fclose($handle);
// }
$numRows = count($trainData);
$numColumns = count($trainData[0]); // Assuming all rows have the same number of columns

// Start an HTML table
echo '<table border="1">';

// Print the table header
echo '<tr>';
for ($j = 0; $j < 10; $j++) {
    //echo '<th>Column ' . ($j + 1) . '</th>';
}
echo '</tr>';

// Print all rows and columns of data
for ($i = 0; $i < 20; $i++) {
    echo '<tr>';
    for ($j = 0; $j < $numColumns; $j++) {
        echo '<td>' . $trainData[$i][$j] . '</td>';
    }
    echo '</tr>';
}

// Close the table
echo '</table>';

// Print the number of rows and columns
echo "Training data has " . $numRows . " rows & " . $numColumns . " columns";



?>
</div>
<form action="test.php ? file_name=<?php echo $uploadedFileName; ?>" method="POST">
    <button type="submit" class="button">Result</button>
    </form>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>

