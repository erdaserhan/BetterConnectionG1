<?php

function getAllNews(PDO $db): array|string
{
    $sql = "SELECT n.title, n.content, n.slug, u.login, u.thename, n.date_published, 
    GROUP_CONCAT(c.title SEPARATOR ' ||| ') AS categ_title, 
	GROUP_CONCAT(c.slug SEPARATOR ' ||| ') AS categ_slug 
    FROM news n
    JOIN user u
        ON n.user_iduser=u.iduser
    LEFT JOIN news_has_category h
		ON h.news_idnews = n.idnews 
    LEFT JOIN category c
        ON h.category_idcategory = c.idcategory 
        WHERE n.`is_published` = 1 
    GROUP BY n.idnews
    ORDER BY n.date_published DESC ;";
    try{
        $query = $db->query($sql);

        if($query->rowCount()==0){
            return "Pas encore de news";
        }

        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;

    }catch(Exception $e){
        return $e->getMessage();
    }
}



function getNewsFromCategorySlug(PDO $db, string $slug): array|string
{
    $sql = "SELECT n.`title`, n.`slug`, SUBSTRING(n.`content`, 1, 260) AS content, n.`date_published`, 
                   u.`login`, u.`thename`,
                   -- champs de category concaténés non fonctionnel dans ce cas
                   GROUP_CONCAT(c.`title` ORDER BY  c.`title` SEPARATOR ' ||| ') AS categ_title, 
	               GROUP_CONCAT(c.`slug` ORDER BY c.`slug` SEPARATOR ' ||| ') AS categ_slug 
	FROM `news` n
	LEFT JOIN `user` u
		ON n.`user_iduser` = u.`iduser`
-- on va sélectionner les champs title (as categ_title) et slug (as categ_slug) de la table category dans tous les cas
    INNER JOIN `news_has_category` h
        ON h.`news_idnews` = n.`idnews`
    INNER JOIN `category` c
        ON h.`category_idcategory` = c.`idcategory`


    INNER JOIN `news_has_category` h2
        ON h2.`news_idnews` = n.`idnews`
    INNER JOIN `category` c2
        ON h2.`category_idcategory` = c2.`idcategory`



-- Condition de récupération
    WHERE n.`is_published` = 1 AND c2.slug = ?
-- on groupe par la clef de la table du FROM (news)
    GROUP BY n.`idnews`    
    ORDER BY n.`date_published` DESC

        ;";

    $prepare= $db->prepare($sql);

    try{
        $prepare->execute([$slug]);
        $result = $prepare->fetchAll();
        $prepare->closeCursor();
        return $result;
    }catch(Exception $e){
        return $e->getMessage();
    }

}


function cutTheText(string $text, int $nbCharacter = 200, bool $cutWord = false) : string
{
    $output = substr($text, 0, $nbCharacter);

    if($cutWord===false) {
        $lastSpace = strrpos($output, " ");
        $output = substr($output, 0, $lastSpace);
    }
    return $output;
}