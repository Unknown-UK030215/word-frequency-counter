<?php
$stopWords = array('the', 'and', 'in', 'on', 'a', 'to', 'for', 'of', 'is', 'it', 'with', 'an', 'as', 'at', 'by', 'this', 'that', 'which', 'be');

function tokenizeText($text, $stopWords) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s]/', '', $text);
    $words = explode(' ', $text);
    $words = array_diff($words, $stopWords);
    return $words;
}

function calculateWordFrequency($words) {
    return array_count_values($words);
}

function sortWordFrequency($wordFrequency, $sortingOrder) {
    if ($sortingOrder === 'desc') {
        arsort($wordFrequency);
    } else {
        asort($wordFrequency);
    }
    return $wordFrequency;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputText = $_POST['text'];
    $sortingOrder = $_POST['sort'];
    $displayLimit = $_POST['limit'];

    $words = tokenizeText($inputText, $stopWords);
    $wordFrequency = calculateWordFrequency($words);
    $sortedWordFrequency = sortWordFrequency($wordFrequency, $sortingOrder);
    $sortedWordFrequency = array_slice($sortedWordFrequency, 0, $displayLimit);

    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<title>Word Frequency Result</title>';
    echo '<link rel="stylesheet" type="text/css" href="styles.css">'; // CSS link added here
    echo '</head>';
    echo '<body>';
    echo '<h1 style="text-align:center;">Word Frequency Result</h1>';
    echo '<table border="1"><tr><th>Word</th><th>Frequency</th></tr>';
    
    foreach ($sortedWordFrequency as $word => $frequency) {
        echo "<tr><td>" . htmlspecialchars($word) . "</td><td>" . htmlspecialchars($frequency) . "</td></tr>";
    }

    echo '</table>';
    echo '</body>';
    echo '</html>';
}
?>
