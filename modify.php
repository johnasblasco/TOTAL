<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Load the XML file
    $xml = simplexml_load_file("fruits.xml");

    // Debugging: Print POST data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Get basket number from form data
    $basketNumber = $_POST["basketNumber"];

    // Debugging: Print basket number
    echo "Basket Number: $basketNumber<br>";

    // Find the basket in XML with the matching basket number
    foreach ($xml->children() as $basket) {
        if ($basket->basketNumber == $basketNumber) {
            // Debugging: Print basket before modification
            echo "Basket Before Modification:<br>";
            echo "<pre>";
            print_r($basket);
            echo "</pre>";

            // Update fruits based on form data
            foreach ($_POST as $key => $value) {
                // Check if the key starts with "fruit_"
                if (strpos($key, 'fruit_') === 0) {
                    // Extract fruit name from the key
                    $fruitName = substr($key, strlen('fruit_'));

                    // Debugging: Print fruit name and value
                    echo "Fruit: $fruitName, Value: $value<br>";

                    // Update fruit value in XML
                    foreach ($basket->fruit as $fruitNode) {
                        if ($fruitNode['name'] == $fruitName) {
                            $fruitNode[0] = $value;
                        }
                    }
                }
            }

            // Debugging: Print basket after modification
            echo "Basket After Modification:<br>";
            echo "<pre>";
            print_r($basket);
            echo "</pre>";

            // Save changes back to XML file
            $xml->asXML("fruits.xml");

            // Redirect back to index.html
            header("Location: index.html");
            exit;
        }
    }

    // If basket number not found, display error
    echo "Basket not found.";
}
?>
