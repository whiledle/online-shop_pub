<?php

require_once('Db.php');

class Product
{
    public function getAllProducts($offset) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT * FROM products_v2 WHERE photo_path != '' AND quantity != '0' AND quantity != '9999' AND quantity != '' ORDER BY id LIMIT 21 OFFSET $offset");
        $products = $query->fetchAll();
        return $products;
    }

    public function getAllProductsForMain() {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT * FROM products_v2 WHERE photo_path != '' AND quantity != '0' AND quantity != '9999' AND quantity != '' ORDER BY id DESC LIMIT 12");
        $products = $query->fetchAll();
        return $products;
    }

    public function getProductsNew($word) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT * FROM products_v2 WHERE MATCH (categories) AGAINST ('$word') ORDER BY rand()");
        $products = $query->fetchAll();
        return $products;
    }

    public function getProductsByWords($word) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT * FROM products_v2 WHERE MATCH (name, categories, composition, product_line, description, set_number) AGAINST ('$word')");
        $products = $query->fetchAll();
        return $products;
    }

    public function getCountProduct($filter = NULL, $value = NULL) {
        $connect = Db::getConnection();
        if($filter == NULL) {
            $query = $connect->query("SELECT COUNT(1) FROM products_v2 WHERE photo_path != '' AND quantity != '0' AND quantity != '9999' AND quantity != ''");
        	$arr = $query->fetch();
        	return $arr;
        } else {
            $query = $connect->query("SELECT COUNT(1) FROM filter WHERE filter = '$filter' AND value = '$value'");
        	$arr = $query->fetchAll();
        	return $arr;
        }
    }

    public function getProduct($id) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT photo, name, price, link, photo_path, quantity, set_number, volume, product_line FROM products_v2 WHERE id = '$id'");
        $product = $query->fetch();
        return $product;
    }

    public function getProductAllInfo($link) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT * FROM products_v2 WHERE link = '$link'");
        $product = $query->fetch();
        return $product;
    }

    public function getProductLines() {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT product_line FROM products_v2");
        $products = $query->fetchAll();
        foreach ($products as $row) {
            $arr[] = $row['product_line'];
        }
        $result = array_unique($arr);
        return $result;
    }

    public function getProductsByCategory($offset, $categoryId) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT * FROM products_v2 WHERE MATCH (categories) AGAINST ('$categoryId') AND quantity != 0 AND quantity != 9999 AND quantity != '' ORDER BY id DESC LIMIT 21 OFFSET $offset");
        $products = $query->fetchAll();
        return $products;
    }

    public function getProductsByPartofWord($data) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT name, price, photo_path, description, link FROM products_v2 WHERE quantity != 0 AND quantity != 9999 AND quantity != '' AND name LIKE concat('%', '$data', '%') ORDER BY name LIKE concat('$data', '%') DESC,
        ifnull(nullif(instr(name, concat(' ', '$data')), 0), 99999), ifnull(nullif(instr(name, '$data'), 0), 99999), name ASC LIMIT 7");
        $products = $query->fetchAll();
        return $products;
    }

    public function getCountProductsByCategory($categoryId) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT COUNT(1) FROM products_v2 WHERE MATCH (categories) AGAINST ('$categoryId') AND quantity != 0 AND quantity != 9999 AND quantity != ''");
        $count = $query->fetch();
        return $count;
    }

    public function getProductsByLines($line) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT * FROM products_v2 WHERE product_line = '$line' AND quantity != 0 AND quantity != 9999 AND quantity != '' ORDER BY id DESC");
        $products = $query->fetchAll();
        return $products;
    }

    public function getCountProductsByLines($line) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT COUNT(1) FROM products_v2 WHERE product_line = '$line' AND quantity != 0 AND quantity != 9999 AND quantity != ''");
        $count = $query->fetch();
        return $count;
    }

    public function getProductIdsByFilter($value) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT product_id FROM filter WHERE value = '$value'");
        $result = $query->fetchAll();
        return $result;
    }

    public function getProductByProduct_id($product_id) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT * FROM products_v2 WHERE product_id = '$product_id'");
        $product = $query->fetch();
        return $product;
    }

    public function getProductsBySale() {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT * FROM products_v2 WHERE sale_status = 1 AND quantity != 0 AND quantity != 9999 AND quantity != '' ORDER BY id DESC");
        $products = $query->fetchAll();
        return $products;
    }

    public function getCountProductsBySale() {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT COUNT(1) FROM products_v2 WHERE sale_status = 1 AND quantity != 0 AND quantity != 9999 AND quantity != ''");
        $count = $query->fetch();
        return $count;
    }

    public function getProductIdByLink($link) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT id FROM products_v2 WHERE link = '$link'");
        $result = $query->fetch();
        return $result['id'];
    }

    public function getProductsLinkPhotoByLines($line, $id) {
        $connect = Db::getConnection();
        $query = $connect->query("SELECT photo_path, name, link FROM products_v2 WHERE product_line = '$line' AND id != $id AND quantity != 0 AND quantity != 9999 AND quantity != '' ORDER BY id DESC");
        $products = $query->fetchAll();
        return $products;
    }
}

?>
