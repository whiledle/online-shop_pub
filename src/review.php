<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/Product.php');

if ( $_POST['name_action'] == 'leave_review' ) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/Review.php');
    $prod = new Product;
    $review = new Review;
    $review_comment = '';

    if ( isset( $_POST['review_value'] ) && !empty( $_POST['review_value'] ) ) {
        $review_value = htmlspecialchars( trim( $_POST['review_value'] ) );
        $review_value = (int)$review_value;
    }

    if ( isset( $_POST['review_comment'] ) && !empty( $_POST['review_comment'] ) ) {
        $review_comment = htmlspecialchars( trim( $_POST['review_comment'] ) );
    }

    if ( isset( $_POST['pathname'] ) && !empty( $_POST['pathname'] ) ) {
        $pathname = htmlspecialchars( trim( $_POST['pathname'] ) );
        $pathname = str_replace( '/', '', $pathname );
    }

    if ( isset( $review_value ) && $review_value != 0 && $review_value != '' && isset( $pathname ) && $pathname !== 0 && $pathname != '' ) {
        $product_id = $prod->getProductIdByLink($pathname);
        $user_id    = htmlspecialchars( trim( $_SESSION['id'] ) );
        $user_ip    = htmlspecialchars( trim( $_SERVER['REMOTE_ADDR']; ) );

        if ( $review->createReview( $product_id, $user_id, $review_value, $review_comment, $user_ip ) ) {
            echo '200';
            die;
        } else {
            echo '400';
            die;
        }
    }
}

?>
