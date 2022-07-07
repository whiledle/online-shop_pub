<?php

require_once('Db.php');

class Review
{
	public function createReview( $product_id, $user_id, $review_value, $review_comment, $user_ip ) {
		$connect = Db::getConnection();
		try {
			$connect->beginTransaction();
			$connect->exec("INSERT INTO reviews (product_id, user_id, review_value, review_comment, user_ip)
             VALUES ('$product_id', '$user_id', '$review_value', '$review_comment', '$user_ip')");

			$connect->commit();

			return true;
		} catch (Exception $e) {
			$connect->rollBack();
			echo "Error: " . $e->getMessage();
			return false;
		}
	}

	public function getProductReviews( $product_id ) {
		$connect = Db::getConnection();
        $query = $connect->query("SELECT * FROM reviews WHERE product_id = '$product_id' ORDER BY id DESC");
        $reviews = $query->fetchAll();
        return $reviews;
	}

	public function haveReview( $product_id, $user_id ) {
		$connect = Db::getConnection();
        $query = $connect->query("SELECT * FROM reviews WHERE product_id = '$product_id' and user_id = '$user_id'");
        $reviews = $query->fetchAll();
		if ( !empty( $reviews ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function getCountProductReviews( $product_id ) {
		$connect = Db::getConnection();
        $query = $connect->query("SELECT COUNT(1) FROM reviews WHERE product_id = '$product_id'");
        $count = $query->fetch();
        return $count['COUNT(1)'];
	}
}

?>
