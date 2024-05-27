<?php

include 'components/connect.php';

if(isset($_GET['q'])){
    $search_box = $_GET['q'];
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE ?");
    $select_products->execute(['%' . $search_box . '%']);
    if($select_products->rowCount() > 0) {
        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            echo '<a href="quick_view.php?pid=' . $fetch_products['id'] . '" class="box">';
            echo '<img src="uploaded_img/' . $fetch_products['image'] . '" alt="">';
            echo '<div class="name">' . $fetch_products['name'] . '</div>';
            echo '<div class="price">$' . $fetch_products['price'] . '</div>';
            echo '</a>';
        }
    } else {
        echo '<p class="empty">No products found!</p>';
    }
} else {
    echo '<p class="empty">Search query is missing!</p>';
}

?>





