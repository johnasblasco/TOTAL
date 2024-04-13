<?php
// Check if the fruitToDelete is set in the POST data
if(isset($_POST['fruitToDelete'])) {
    $fruitToDelete = $_POST['fruitToDelete'];

    // Load the XML data from the fruits.xml file
    $xmlData = file_get_contents('fruits.xml');
    $xml = new SimpleXMLElement($xmlData);

    $fruitDeleted = false;
    // Iterate through baskets and fruits to find and delete the specified fruit category
    foreach ($xml->basket as $basket) {
        foreach ($basket->fruit as $index => $fruit) {
            if ((string)$fruit['name'] === $fruitToDelete) {
                unset($basket->fruit[$index]);
                $fruitDeleted = true;
                break; // Exit the inner loop once the fruit is deleted
            }
        }
        if ($fruitDeleted) {
            break; // Exit the outer loop if the fruit is deleted
        }
    }

    // Save the modified XML data back to the fruits.xml file
    $xmlData = $xml->asXML();
    file_put_contents('fruits.xml', $xmlData);

    // Send response to indicate success or failure
    if ($fruitDeleted) {
        echo 'success';
    } else {
        echo 'Fruit category not found!';
    }
} else {
    // Handle the case when fruitToDelete is not set
    echo 'Error: No fruit category specified for deletion.';
}
?>