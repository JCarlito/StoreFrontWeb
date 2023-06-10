<?php

class Cart {

    private $items = array();


    public function addItem($id, $brand, $model, $price, $stock) {
        // Check if the item already exists in the cart
        foreach ($this->items as &$temp_item) {
            if ($temp_item["id"] == $id) {
                // If it exists, increase the count and return
                $temp_item["stock"] += $stock;
                return;
            }
        }

        // If it doesn't exist, add a new item
        $item = array(
            "id" => $id,
            "brand" => $brand,
            "model" => $model,
            "price" => $price,
            "stock" => $stock
        );
        array_push($this->items, $item);
    }

    public function removeItem($index) {
        array_splice($this->items, $index, 1);
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item["price"] * $item["stock"];
        }
        return $total;
    }

    public function displayCart() {
        // Display the grouped items
        echo "<table><tr><th>Brand</th><th>Name</th><th>Cost</th><th>Amount</th></tr>";
        foreach ($this->items as $item) {
            echo "<tr>";
            echo "<td>" . $item["brand"] . "</td>";
            echo "<td>" . $item["model"] . "</td>";
            echo "<td>$" . $item["price"] . "</td>";
            echo "<td>" . $item["stock"] . "</td>";
            echo "</tr>";
        }
        echo "<tr>";
        echo "<td>Total Price: $</td>";
        echo "<td>" . $this->getTotalPrice() . "</td>";
        echo "</table>";
    }

}
