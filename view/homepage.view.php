<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <title>BetterConnection | homepage</title>
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <?php
require_once "menu.view.php";
    ?>
        <!-- Page Header-->
        <header class="masthead" style="background-image: url('assets/img/home-bg.jpg')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>homepage</h1>
                            <span class="subheading">Notre page d'accueil</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main Content-->        
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-12">
                <?php
                foreach($news as $newsContent):
                ?>
                    <!-- Post preview-->
                    <div class="post-preview">
                        <a href="?detailArticle=<?=$newsContent['slug']?>">
                            <h2 class="post-title"><?=$newsContent['title']?></h2>
                            <h4 class="post-subtitle"><?=cutTheText($newsContent['content'],255)?>... Lire la suite</h4>
                        </a>
                        <div>
                        <?php
                        $categ_slug = explode("|||", $newsContent['categ_slug']);
                        $categ_title = explode("|||", $newsContent['categ_title']);
                        //var_dump($categ_slug);
                        foreach($categ_slug as $key => $value):
                        ?>
                        <a href="?section=<?=$value?>"><?=$categ_title[$key]?></a> |
                        <?php
                        endforeach
                        ?>
                        </div>
                        <p class="post-meta">                       
                            Posted by
                        <a href="?detailArticle=<?=$item['slug']?>">
                            <h2 class="post-title"><?=$item['title']?></h2>
                            <h5 class="post-subtitle"><?=cutTheText($item['content'],255)?>... Lire la suite</h5>
                        </a><div>
                        <?php
                    // si on a des rubriques
                    if(!is_null($item['categ_slug'])):
                        // Pour les catégories, on va devoir couper les chaînes de caractères quand on trouve |||
                        $categ_slug = explode("|||",$item['categ_slug']);
                        $categ_title = explode("|||",$item['categ_title']);
                        // tant qu'on a des valeurs
                        foreach($categ_slug as $key => $value):
                            // on affiche la valeur de la variable où on fait la boucle dans le lien et la variable contenant les titres en utilisant la clef correspondante
                        ?>
                        <a href="?section=<?=$value?>"><?=$categ_title[$key]?></a> | 
                        <?php
                        endforeach;
                    endif;
                        ?>
                    </div>
                        <p class="post-meta">
                            Posté par
                            <?php
                            $name = $newsContent['thename'] ?? "Anonyme";
                            $linkName = $newsContent['login'] ?? "#";
                            ?>
                            <a href="?author=<?=$linkName?>"><?=$name?></a>
                            <?php
                            $date = $newsContent['date_published'] ?? "";
                            $date = strtotime($date);
                            echo ($date)? " le " .date("d/m/Y \à H\hi", $date): " Pas publié !";
                            ?>
                        </p>
                    </div>
                    
                    <!-- Divider-->
                    <hr class="my-4" />
                    <!-- Post preview-->                   
                <?php
                endforeach;
                ?>                 
                   
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <ul class="list-inline text-center">
                            <li class="list-inline-item">
                                <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="small text-center text-muted fst-italic">Copyright &copy; Better <?=date("Y")?></div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>