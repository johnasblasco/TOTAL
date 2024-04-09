<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo"<script>console.log( " . print_r($_POST) . " ) </script>";
    // Retrieve basket number from the form
    $basketNumber = $_POST["basketNumber"];
    // Retrieve the updated fruit quantities
    $fruitQuantities = $_POST["fruits"];

    // Load the XML file
    $xml = new DOMDocument();
    if ($xml->load("fruits.xml")) {
        // Find the basket with the matching ID
        $baskets = $xml->getElementsByTagName("basket");
        $basketFound = false;
        foreach ($baskets as $basket) {
            $basketNode = $basket->getElementsByTagName("basketNumber")->item(0);
            if ($basketNode->nodeValue == $basketNumber) {
                $basketFound = true;
                // Update fruit quantities
                $fruits = $basket->getElementsByTagName("fruit");
                foreach ($fruits as $fruit) {
                    $fruitName = $fruit->getAttribute("name");
                    foreach ($fruitQuantities as $fruitKey => $fruitValue) {
                        if ($fruitName == $fruitKey) {
                            $fruit->nodeValue = $fruitValue;
                            break;
                        }
                    }
                }

                // Save the changes back to the XML file
                if ($xml->save("fruits.xml")) {
                    // Send a success message
                    echo "Fruits updated successfully in PHP";
                    exit(); // Exit after successful update
                } else {
                    echo "Failed to save changes to XML file";
                }
            }
        }

        // If basket is not found, send an error message
        if (!$basketFound) {
            echo "Basket not found";
        }
    } else {
        echo "Failed to load XML file";
    }
} else {
    // If the form is not submitted, send an error message
    echo "Form not submitted";
}
?>
