<?php

// Get the fruit name from the AJAX request
$fruitName = $_POST['fruitName'];

// Load the XML data from the fruits.xml file
$xmlData = file_get_contents('fruits.xml');
$xml = new SimpleXMLElement($xmlData);

// Add the new fruit category to each basket with a default quantity of 0
foreach ($xml->basket as $basket) {
  $newFruit = $basket->addChild('fruit', 0);
  $newFruit->addAttribute('name', $fruitName);
}

// Save the modified XML data to the fruits.xml file
$xmlData = $xml->asXML();
file_put_contents('fruits.xml', $xmlData);

// Send the modified XML data back to the AJAX request
echo $xmlData;

?>