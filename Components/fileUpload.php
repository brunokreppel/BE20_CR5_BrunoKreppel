<?php
    function fileUpload($picture, $source = "user"){

        if($picture["error"] == 4){
            $pictureName = "avatar.png";
            if($source == "product"){
                $pictureName = "product.png";
            }
            $message = "No picture has been chosen, but you can upload an image later :)";
        }else{
            $checkIfImage = getimagesize($picture["tmp_name"]);
            $message = $checkIfImage ? "Ok" : "Not an image";
        }
 
        if($message == "Ok"){
            $ext = strtolower(pathinfo($picture["name"],PATHINFO_EXTENSION));
            $pictureName = uniqid(""). "." . $ext;
            $destination = "../assets/{$pictureName}";
            move_uploaded_file($picture["tmp_name"], $destination);
        }
 
        return [$pictureName, $message];
    }