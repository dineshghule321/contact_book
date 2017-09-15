<?php

/**
 * Created by PhpStorm.
 * User: dinesh
 * Date: 5/9/17
 * Time: 5:59 PM
 */
class User
{
    public $connection = "";

    function __construct()
    {
        $this->connection = new DB("dbSystem", 'FALSE');
    }

    function validateLogin($email, $hash)
    {
        return $this->connection->select("users", array(), array("email_address" => "{$email}", "password_hash" => "{$hash}"));
    }

    function isAdminExists($email)
    {
        return $this->connection->select("users", array(), array("email_address" => "{$email}", "status" => 1));
    }

    function changePassword($email, $newp)
    {
        return $this->connection->update("users", array("password_hash" => $newp), array("email_address" => "{$email}"));
    }

    function updateToken($email, $token)
    {
        return $this->connection->update("users", array("auth_token" => $token), array("email_address" => "{$email}"));
    }

    function activateUser($email, $hash)
    {
        $hash = sha1Md5DualEncryption($hash);

        return $this->connection->update("users", array("password_hash" => $hash, "status" => 1), array("email_address" => "{$email}"));
    }

    function changeAdminProfilePic($email, $imageName)
    {
        global $docRoot;
        $result = $this->connection->update("users", array("profile_pic_path" => $imageName), array("email_address" => "{$email}"));

        if (noError($result)) {

            $RootURLProPicNew = "{$docRoot}assets/uploads/profilePics/";
            $RootURLProPictOld = $RootURLProPicNew . $_SESSION["profile_pic"];
            if ($_SESSION["profile_pic"] != "admin.jpg") {
                unlink($RootURLProPictOld);
            }

            if ($_SESSION["profile_pic"] != "admin.jpg") {
                unset($_SESSION["profile_pic"]);
            }
            $_SESSION["profile_pic"] = $imageName;
            $errMsg = "Profile Picture Updated Successfully.";
            return set_error_stack(-1, $errMsg);
        } else {
            return set_error_stack(4);

        }

    }

    function updateUser($email, $fname, $lname, $address)
    {
        return $this->connection->update("users", array("first_name" => $fname, "last_name" => $lname, "address" => $address), array("email_address" => "{$email}"));
    }

}