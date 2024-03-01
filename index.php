<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Madimi+One&display=swap');
    *{
      font-family: Madimi One;
      text-align: center;
      margin:0;
      padding:0;
      box-sizing: border-box;
    }
    table{
      width:100%;
    }
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
    tr:nth-child(even){
      background-color:gray;
    }
    th{background-color:gray;}
    <title>Fruit Basket</title>
    th, td {
      padding: 5px;
    }
  </style>
</head>
<body>
  <h1>Fruit Basket</h1>
  <table id="basketTable">
    <thead>
      <tr>
        <th>Basket Number</th>
        <th>Basket Owner</th>
        <th>Apple</th>
        <th>Orange</th>
        <th>Banana</th>
        <th>Grapes</th>
        <th>Pineapple</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $xmlString = file_get_contents("fruits.xml");
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($xmlString);

        $baskets = $xmlDoc->getElementsByTagName("basket");

        // Initialize the total for each fruit
        $fruitTotals = ['Apple' => 0, 'Orange' => 0, 'Banana' => 0, 'Grapes' => 0, 'Pineapple' => 0];

        for ($i = 0; $i < $baskets->length; $i++) {
          $basket = $baskets->item($i);

          $basketNumber = $basket->getElementsByTagName("basketNumber")->item(0)->textContent;
          $basketOwner = $basket->getElementsByTagName("basketOwner")->item(0)->textContent;

          echo "<tr>";
          echo "<td>$basketNumber</td>";
          echo "<td>$basketOwner</td>";

          $fruits = $basket->getElementsByTagName("fruit");
          for ($j = 0; $j < $fruits->length; $j++) {
            $fruit = $fruits->item($j);
            $fruitName = $fruit->getAttribute("name");
            $fruitQuantity = $fruit->textContent;

            echo "<td>$fruitQuantity</td>";

            // Update the total for each fruit
            $fruitTotals[$fruitName] += intval($fruitQuantity);
          }

          echo "</tr>";
        }

        // Display the total for each fruit
        echo "<tr>";
        echo "<td></td>";
        echo "<td><strong>TOTAL</strong></td>";
        foreach ($fruitTotals as $fruitName => $total) {
          echo "<td><strong>$total</strong></td>";
        }
        echo "</tr>";
        ?>
    </tbody>
  </table>
</body>
</html>