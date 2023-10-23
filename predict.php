<?php
require 'vendor/autoload.php'; // Include PHP-ML library

use Phpml\Classification\NaiveBayes;
use Phpml\CrossValidation\StratifiedRandomSplit;

// Load your CSV dataset (replace 'dataset.csv' with your actual CSV file)
$dataset = new Phpml\Dataset\CsvDataset('./data/Train_data.csv', 31, true);

// Split the dataset into training and testing sets (adjust as needed)
$split = new StratifiedRandomSplit($dataset, 0.8);

// Create a Naive Bayes classifier
$classifier = new NaiveBayes();

// Train the classifier on the training set
$classifier->train($split->getTrainSamples(), $split->getTrainLabels());

// Collect input values from the form
$inputValues = [];
for ($i = 1; $i <= 31; $i++) {
    $inputName = "attr$i";
    if (isset($_POST[$inputName])) {
        $inputValues[] = floatval($_POST[$inputName]);
    } else {
        $inputValues[] = 0.0; // Set a default value if not provided
    }
}
$numericPrediction = $classifier->predict([$inputValues]);

// Define a mapping for numeric predictions to class labels
$classLabels = [0 => 'abnormal', 1 => 'normal'];

// Check if the numeric prediction exists as a key in the $classLabels array
if (array_key_exists($numericPrediction[0], $classLabels)) {
    // Get the corresponding class label
    $predictedClass = $classLabels[$numericPrediction[0]];
} else {
    // Handle the case where the numeric prediction doesn't match any keys
    $predictedClass = 'unknown';
}

// Display the prediction
?>
<!DOCTYPE html>
<html>
<head>
    <title>Prediction Result</title>
</head>
<body>
    <h1>Prediction Result</h1>
    <p>Class Prediction: <?php echo $predictedClass; ?></p>
    <!-- You can display additional information or links here -->
</body>
</html>
