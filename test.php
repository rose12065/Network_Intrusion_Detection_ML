<?php
require 'vendor/autoload.php';

use Phpml\Classification\NaiveBayes;
use Phpml\Classification\DecisionTree;
use Phpml\Classification\SVC;
use Phpml\CrossValidation\RandomSplit;
use Phpml\Dataset\ArrayDataset; // Import ArrayDataset
use Phpml\Metric\Accuracy;
use Phpml\Metric\Precision;
use Phpml\Metric\Recall;

if(isset($_GET['file_name'])){
    $filename=$_GET['file_name'];
// Load your dataset as arrays (Replace with your actual dataset)
$csvFile = './data/' .$filename;
$data = [];
$labels = [];
$labelMapping = []; // Create a mapping of labels to numerical values

if (($handle = fopen($csvFile, 'r')) !== false) {
    while (($row = fgetcsv($handle, 1000, ',')) !== false) {
        $data[] = array_slice($row, 0, -1); // Remove the last column (labels)
        $label = end($row); // Get the last column as labels
        if (!isset($labelMapping[$label])) {
            $labelMapping[$label] = count($labelMapping); // Assign a unique numerical value to each label
        }
        $labels[] = $labelMapping[$label];
    }
    fclose($handle);
}

// Create an ArrayDataset
$dataset = new ArrayDataset($data, $labels);

// Split the dataset into training and testing sets (80% train, 20% test)
$split = new RandomSplit($dataset, 0.8);
$trainSamples = $split->getTrainSamples();
$trainLabels = $split->getTrainLabels();
$testSamples = $split->getTestSamples();
$testLabels = $split->getTestLabels();


$dtClassifier = new DecisionTree();
$dtClassifier->train($trainSamples, $trainLabels);


$svmClassifier = new SVC();
$svmClassifier->train($trainSamples, $trainLabels);


$dtPredictions = $dtClassifier->predict($testSamples);
$svmPredictions = $svmClassifier->predict($testSamples);


$dtAccuracy = Accuracy::score($testLabels, $dtPredictions);
$svmAccuracy = Accuracy::score($testLabels, $svmPredictions);
function calculatePrecision($truePositives, $falsePositives) {
    return $truePositives / ($truePositives + $falsePositives);
}

function calculateRecall($truePositives, $falseNegatives) {
    return $truePositives / ($truePositives + $falseNegatives);
}

// Calculate precision and recall for Decision Tree
$dtTruePositives = 0;
$dtFalsePositives = 0;
$dtFalseNegatives = 0;

foreach ($testLabels as $i => $trueLabel) {
    if ($trueLabel == $dtPredictions[$i]) {
        if ($trueLabel == 1) {
            $dtTruePositives++;
        }
    } else {
        if ($trueLabel == 1) {
            $dtFalseNegatives++;
        } else {
            $dtFalsePositives++;
        }
    }
}

$dtPrecision = calculatePrecision($dtTruePositives, $dtFalsePositives);
$dtRecall = calculateRecall($dtTruePositives, $dtFalseNegatives);

// Calculate precision and recall for SVM
$svmTruePositives = 0;
$svmFalsePositives = 0;
$svmFalseNegatives = 0;

foreach ($testLabels as $i => $trueLabel) {
    if ($trueLabel == $svmPredictions[$i]) {
        if ($trueLabel == 1) {
            $svmTruePositives++;
        }
    } else {
        if ($trueLabel == 1) {
            $svmFalseNegatives++;
        } else {
            $svmFalsePositives++;
        }
    }
}

$svmPrecision = calculatePrecision($svmTruePositives, $svmFalsePositives);
$svmRecall = calculateRecall($svmTruePositives, $svmFalseNegatives);



echo '<table>';
echo '<tr><th>Model</th><th>Accuracy</th><th>Precision </th><th>Recall</th></tr>';


// SVM results
echo '<tr><td>SVM</td><td>' . $svmAccuracy . '</td><td>' . $svmPrecision . '</td><td>' . $svmRecall . '</td><td>';
echo '</td></tr>';

echo '<tr><td>Decision Tree</td><td>' . $dtAccuracy . '</td><td>' . $dtPrecision  . '</td><td>' . $dtRecall . '</td><td>';
echo '</td></tr>';

echo '</table>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
  // Load the Visualization API and corechart package.
  google.charts.load('current', {'packages':['corechart']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.charts.setOnLoadCallback(drawChart);

  // Callback that creates and populates a data table.
  function drawChart() {
    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Model');
    data.addColumn('number', 'Accuracy');
    data.addColumn('number', 'Precision');
    data.addColumn('number', 'Recall');
    data.addRows([
  ['Decision Tree', <?php echo $dtAccuracy; ?>, <?php echo $dtPrecision; ?>, <?php echo $dtRecall; ?>],
  ['SVM', <?php echo $svmAccuracy; ?>, <?php echo $svmPrecision; ?>, <?php echo $svmRecall; ?>]
]);

    // Set chart options.
    var options = {
      'title': 'Accuracy Comparison',
      'width': 1000,
      'height': 300
    };

    // Instantiate and draw the chart, passing in some options.
    var chart = new google.visualization.BarChart(document.getElementById('accuracyChart'));
    chart.draw(data, options);
  }
</script>

</head>
<body>
<div id="accuracyChart" style="width: 600px; height: 300px;">

<table>
    <tr>
        <th>Model</th>
        <th>Accuracy</th>
        <th>Precision</th>
        <th>Recall</th>
    </tr>

    <!-- SVM results -->
    <tr>
        <td>SVM</td>
        <td><?php echo $svmAccuracy; ?></td>
        <td><?php echo $svmPrecision; ?></td>
        <td><?php echo $svmRecall; ?></td>
    </tr>

    <!-- Decision Tree results -->
    <tr>
        <td>Decision Tree</td>
        <td><?php echo $dtAccuracy; ?></td>
        <td><?php echo $dtPrecision; ?></td>
        <td><?php echo $dtRecall; ?></td>
    </tr>
</table>

</div>
<form action="delete_file.php  ? file_name=<?php echo $filename; ?>" method="post">
    <button type="submit" class="button">Clear</button>
    </form>
</body>
</html>