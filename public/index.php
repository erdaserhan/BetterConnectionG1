<?php


require_once("../config.php");
require_once("../model/CategoryModel.php");
require_once("../model/NewsModel.php");


try {
    $db = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET . ";port=" . DB_PORT, DB_LOGIN, DB_PWD);

    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

} catch (Exception $e) {
    die($e->getMessage());
}

$menuSlug = getAllCategoriesBySlug($db);


if(isset($_GET['section'])){

    $categ = htmlspecialchars(strip_tags(trim($_GET['section'])),ENT_QUOTES);

    $category = getCategoryBySlug($db,$categ);

    if(is_string($category)){
        $message = $category;   
    }elseif($category===false){
        $message = "Rubrique inconnue";
        include_once "../view/404.view.php";
        $db = null;
        exit();
    }

    $newsIntoSection = getNewsFromCategorySlug($db, $categ);

    if(empty($newsIntoSection)){
        $message = "Pas encore d'article dans cette section";
    }

   
    include_once "../view/section.view.php";
}else{

    

    $newsHomepage = getAllNews($db);

   
    include_once "../view/homepage.view.php";
}

$db = null;
