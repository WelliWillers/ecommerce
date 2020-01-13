<?php

use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use Hcode\Model\Product;

$app->get("/admin/products", function(){

    User::verifyLogin();

    $products = Product::listAll();
    
    $page = new PageAdmin();

    $page->setTpl("products", [
        "products"=>$products
    ]);

});

$app->get('/admin/products/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl('products-create');

});

$app->post('/admin/products/create', function(){

	User::verifyLogin();

	$products = new Product();

	$products->setData($_POST);

	$products->save();

	header("Location: /admin/products");
	exit;

});

$app->get('/admin/products/:idproduct/delete', function($idproduct){

	User::verifyLogin();

	$products = new Product();

	$products->get((int)$idproduct);

	$products->delete();

	header("Location: /admin/products");
	exit;

});

$app->get('/admin/products/:idproduct', function($idproduct){

	User::verifyLogin();

	$products = new Product();

	$products->get((int)$idproduct);

	$page = new PageAdmin();

	$page->setTpl('products-update', array(
		"product"=>$products->getValues()
	));

});

$app->post('/admin/products/:idproduct', function($idproduct){

	User::verifyLogin();

	$products = new Product();

	$products->get((int)$idproduct);

	$products->setData($_POST);

	$products->save();

	// var_dump($_FILES);
	// exit;

	$products->setPhoto($_FILES["file"]);

	header("Location: /admin/products");
	exit;

});

?>