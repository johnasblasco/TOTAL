<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Validate and sanitize input
$basketNumber = isset($_POST['basketNumber'])? htmlspecialchars($_POST['basketNumber']) : '';
$fruits = $_POST;
unset($fruits['basketNumber']);

// Load the XML file
$xmlDoc = new DOMDocument();
if (!$xmlDoc->load('fruits.xml')) {
    die('Error: Unable to load XML file');
}

// Find the basket with the matching ID
$baskets = $xmlDoc->getElementsByTagName('basket');
$basketFound = false;
foreach ($baskets as $basket) {
    if ($basket->getElementsByTagName('basketNumber')[0]->textContent == $basketNumber) {
        $basketFound = true;
        // Update the number of fruits in each category
        foreach ($fruits as $fruitName => $fruitCount) {
            $fruitElements = $basket->getElementsByTagName($fruitName);
            foreach ($fruitElements as $fruitElement) {
                $fruitElement->nodeValue = $fruitCount;
            }
        }
        break;
    }
}

// Save the updated XML file
if ($basketFound && !$xmlDoc->save('fruits.xml')) {
    die('Error: Unable to save XML file');
}
else{
  $xmlDoc->save('fruits.xml');
}

// Send a response back to the client
echo 'Fruits updated successfully';
?>