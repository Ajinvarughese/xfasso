<?php 
    require '../../connections/productdb.php';
    require './Ratings.php';

    if(isset($_POST["postRating"])) {
        $starCount = filter_var($_POST['starCount'], FILTER_SANITIZE_NUMBER_INT);
        $desc = filter_var($_POST['desc'], FILTER_SANITIZE_SPECIAL_CHARS);
        $prodId = 4;

        $rating = new Ratings($starCount, "asda", "varuhgese", $desc);

        $newRatingData = json_decode(json_encode($rating), true);

        $fetchQ = "SELECT rating FROM products WHERE productId = {$prodId}";
        $result = $conn->query($fetchQ);

        if ($result && $row = $result->fetch_assoc()) {
            $existingRatingData = json_decode($row['rating'], true);
            $existingRatingData[] = $newRatingData;
            $updatedRatingData = json_encode($existingRatingData);
            $updateQ = "UPDATE products SET rating = '{$updatedRatingData}' WHERE productId = {$prodId}";
            $conn->query($updateQ);
        }
        $conn->close();
    }
?>
