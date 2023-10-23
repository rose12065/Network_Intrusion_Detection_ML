<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 
    <title>Document</title>
<style>
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


<?php
use Phpml\Classification\NaiveBayes;
use Phpml\ModelManager;

if(isset($_GET['file_name'])){
    $filename=$_GET['file_name'];
require 'vendor/autoload.php'; // Include PHP-ML library

// Load your dataset and split it into features (samples) and labels
// Specify the path to your CSV file

$dataset = './data/' .$filename;

// Initialize arrays to store samples and labels
$samples = [];
$labels = [];

// Open the CSV file for reading
if (($handle = fopen($dataset, 'r')) !== false) {
    // Read the header row (optional, if you want to skip it)
    $header = fgetcsv($handle);

    // Read each row of the CSV file
    while (($row = fgetcsv($handle)) !== false) {
        // Extract the features (samples) from all columns except the last one (which contains labels)
        $sample = array_slice($row, 0, -1);
        $samples[] = array_map('floatval', $sample); // Convert values to float (assuming they are numeric)

        // Extract the label from the last column and add it to the labels array
        $labels[] = $row[count($row) - 1];
    }

    // Close the CSV file
    fclose($handle);
}

// Display the extracted samples and labels

// for ($i = 0; $i < count($samples); $i++) {
//     echo "Sample: " . implode(', ', $samples[$i]) . " | Label: " . $labels[$i] . "<br>";
// }


// Split the dataset into training and testing sets (e.g., 80% training, 20% testing)
$splitIndex = (int)(count($samples) * 0.8); // Adjust the split ratio as needed
$trainingSamples = array_slice($samples, 0, $splitIndex);
$trainingLabels = array_slice($labels, 0, $splitIndex);
$testingSamples = array_slice($samples, $splitIndex);
$testingLabels = array_slice($labels, $splitIndex);

// Create a Naive Bayes classifier and train it
$classifier = new NaiveBayes();
$classifier->train($trainingSamples, $trainingLabels);

// Use the trained classifier to predict labels for the test set
$predictions = $classifier->predict($testingSamples);

// Calculate accuracy
$correctPredictions = 0;
$totalPredictions = count($testingLabels);

for ($i = 0; $i < $totalPredictions; $i++) {
    if ($predictions[$i] === $testingLabels[$i]) {
        $correctPredictions++;
    }
}

$accuracy = $correctPredictions / $totalPredictions;

echo "Accuracy: " . ($accuracy * 100) . "%\n";

// Optionally, you can save the trained model for future use
$manager = new ModelManager();
$manager->saveToFile($classifier, 'naive_bayes_model.phpml');
}
?>
</div>
<form action="delete_file.php  ? file_name=<?php echo $filename; ?>" method="post">
    <button type="submit" class="button">Clear</button>
    </form>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>

