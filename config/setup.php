<?php
$DB_DSN 	 = 'mysql:host=localhost;';
$DB_NAME	 = 'ecommerce';
$DB_USER 	 = 'root';
$DB_PASSWORD = '';

/******* CREATING A NEW DATABASE Ecommerce **************/

try
{
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $con = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $options);

    $sql = "DROP DATABASE IF EXISTS ". $DB_NAME . ";";
    $con->exec($sql);

    $sql = "CREATE DATABASE IF NOT EXISTS " . $DB_NAME . ";";
    $con->exec($sql);
    
    echo "DataBase Created Successfully\n";
    $con->exec("use " . $DB_NAME . ";");
}
catch(PDOException $e)
{
    echo "CREATING DATABASE FAILED " . $e->getMessage();
    exit(-1);
}

/* ****************************************************** */

/**************** CREATING USERS TABLE **********************/

try
{
    //$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    //$con = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $sql = "CREATE TABLE `users`(
        `UserId` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `Username` varchar(255) NOT NULL,
        `Password` varchar(255) NOT NULL,
        `Email` varchar(255) NOT NULL,
        `FullName` varchar(255) NOT NULL,
        `TrustStatus` smallint DEFAULT 0,
        `RegStatus` smallint DEFAULT 0,
        `GroupID` smallint DEFAULT 0,
        `Date` date NOT NULL,
        `Avatar` varchar(255) NOT NULL
    )ENGINE=InnoDB";

    $con->exec($sql);
    echo "User Table Created Successfully";
}
catch(PDOException $e)
{
    echo "CREATING USERS TABLE FAILED " . $e->getMessage();
}
/******************************************************* */

/**************** CREATING CATEGORIES TABLE **********************/

try
{
 
    $sql = "CREATE TABLE `categories`(
        `ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `Name` varchar(255) NOT NULL,
        `Description` text NOT NULL,
        `Ordering` smallint NOT NULL,
        `Visibility` smallint DEFAULT 0,
        `Allow_comments` smallint DEFAULT 0,
        `Allow_ads` smallint DEFAULT 0
        )ENGINE=InnoDB";

    $con->exec($sql);
    echo "Categories Table Created Successfully";
}
catch(PDOException $e)
{
    echo "CREATING CATEGORIES TABLE FAILED " . $e->getMessage();
}
/******************************************************* */

/**************** CREATING ITEMS TABLE **********************/

try
{
    $sql = "CREATE TABLE `items`(
        `ItemId` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `Name` varchar(255) NOT NULL,
        `Description` text NOT NULL,
        `Price` varchar(255) NOT NULL,
        `CountryMade` varchar(255) NOT NULL,
        `Date` date NOT NULL,
        `image` varchar(255) NOT NULL,
        `Status` smallint NOT NULL,
        `Approve` smallint NOT NULL,
        `UserId` int(11) NOT NULL,
        CONSTRAINT `fk_items_userid`
        FOREIGN KEY (`UserId`)
        REFERENCES `ecommerce`.`users` (`UserId`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
        `CatId` int(11) NOT NULL,
        CONSTRAINT `fk_categories_catid`
        FOREIGN KEY (`CatId`)
        REFERENCES `ecommerce`.`categories` (`ID`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
        
        )ENGINE=InnoDB";


    $con->exec($sql);
    echo "Items Table Created Successfully";
}
catch(PDOException $e)
{
    echo "CREATING ITEMS TABLE FAILED " . $e->getMessage();
}
/******************************************************* */


/**************** CREATING COMMENTS TABLE **********************/

try
{
    $sql = "CREATE TABLE `comments`(
        `CommentId` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `UserComment` varchar(255) NOT NULL,
        `Comment` text NOT NULL,
        `Date` datetime NOT NULL,
        `Status` SMALLINT NOT NULL DEFAULT '0',
        `UserId` int(11) NOT NULL,
        `ItemId` int(11) NOT NULL,
        CONSTRAINT `fk_comments_userid`
        FOREIGN KEY (`UserId`)
        REFERENCES `ecommerce`.`users` (`UserId`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
        CONSTRAINT `fk_comments_itemid`
        FOREIGN KEY (`ItemId`)
        REFERENCES `ecommerce`.`items` (`ItemId`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
        )ENGINE=InnoDB";
    $con->exec($sql);
    echo "Comments Table Created Successfully";
}
catch(PDOException $e)
{
    echo "CREATING COMMENTS TABLE FAILED " . $e->getMessage();
}
/******************************************************* */


?>