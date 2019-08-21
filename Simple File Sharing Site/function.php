<?php
    //generate file paths for different functions
    function dirPath(){
        return "/home/Joey/src"; 
    }

    function usersCredentialFilePath(){
        return "/home/Joey/key/users.txt"; 
    }

    function generateHeader(){
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head> <meta charset="UTF-8"><title> File Sharing Site </title>
        	<link rel="stylesheet" type="text/css" href="StyleSheet.css">
        </head><body>';
    }

    function generateFooter(){
        return '</body></html>';
    }

    //this function is cited from https://stackoverflow.com/questions/2050859/copy-entire-contents-of-a-directory-to-another-using-php
    //it is for recursivly coping files from one directory to another
    function recurse_copy($src,$dst) { 
        $dir = opendir($src); 
        @mkdir($dst); 
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' )) { 
                if ( is_dir($src . '/' . $file) ) { 
                    recurse_copy($src . '/' . $file,$dst . '/' . $file); 
                } 
                else { 
                    copy($src . '/' . $file,$dst . '/' . $file); 
                } 
            } 
        } 
        closedir($dir); 
    } 

?>