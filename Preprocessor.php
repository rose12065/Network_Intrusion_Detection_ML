<?php
require 'vendor/autoload.php';

use Phpml\Classification\Ensemble\AdaBoost;
use Phpml\Classification\DecisionTree;
use Phpml\CrossValidation\RandomSplit;
use Phpml\Dataset\ArrayDataset;
use Phpml\Metric\Accuracy;
use Phpml\Metric\ConfusionMatrix;

// Load your dataset as arrays (Replace with your actual dataset)
$csvFile = './data/Test_data.csv';
$data = [];
$labels = [];

if (($handle = fopen($csvFile, 'r')) !== false) {
    while (($row = fgetcsv($handle, 1000, ',')) !== false) {
        $data[] = array_slice($row, 0, -1); // Remove the last column (labels)
        $labels[] = end($row); // Get the last column as labels
    }
    fclose($handle);
}

// Convert labels to binary labels for one class
$binaryLabels = array_map(function ($label) {
    return $label === 'class_name_to_classify' ? 1 : 0;
}, $labels);

// Create an ArrayDataset
$dataset = new ArrayDataset($data, $binaryLabels);

// Split the dataset into training and testing sets (80% train, 20% test)
$split = new RandomSplit($dataset, 0.8);
$trainSamples = $split->getTrainSamples();
$trainLabels = $split->getTrainLabels();
$testSamples = $split->getTestSamples();
$testLabels = $split->getTestLabels();

// Train AdaBoost classifier with Decision Tree as the base classifier
$adaBoostClassifier = new AdaBoost(100, new DecisionTree());
$adaBoostClassifier->train($trainSamples, $trainLabels);

// Predict using the trained AdaBoost classifier
$adaBoostPredictions = $adaBoostClassifier->predict($testSamples);

// Evaluate accuracy
$adaBoostAccuracy = Accuracy::score($testLabels, $adaBoostPredictions);

// Calculate confusion matrix
$adaBoostConfusionMatrix = ConfusionMatrix::compute($testLabels, $adaBoostPredictions);

// Output results
echo "AdaBoost Accuracy: " . $adaBoostAccuracy . PHP_EOL;
echo "AdaBoost Confusion Matrix:" . PHP_EOL;
print_r($adaBoostConfusionMatrix);
