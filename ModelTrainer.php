<?php
require 'vendor/autoload.php'; // Include PHP-ML library

use Phpml\Ensemble\RandomForestClassifier;
use Phpml\Dataset\ArrayDataset;
use Phpml\Preprocessing\Normalizer;

class ModelTrainer {
    public static function trainModel($data) {
        // Add your model training logic here
        // This is a simplified example using PHP-ML's RandomForestClassifier

        // Assuming the last column is the label
        $labels = array_column($data, count($data[0]) - 1);
        $features = array_map(function ($row) {
            array_pop($row); // Remove the label column
            return $row;
        }, $data);

        // Preprocess the features (e.g., normalize)
        $normalizer = new Normalizer();
        $normalizer->fit($features);
        $features = $normalizer->transform($features);

        // Create a dataset
        $dataset = new ArrayDataset($features, $labels);

        // Train the Random Forest classifier
        $classifier = new RandomForestClassifier();
        $classifier->train($dataset);

        return $classifier;
    }
}
?>
