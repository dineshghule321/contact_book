<?php
/**
 * Created by PhpStorm.
 * User: dinesh
 * Date: 16/9/17
 * Time: 10:26 AM
 */

session_start();
require_once("../../config/config.php");
require_once("../../models/contact/Contact.php");

/*
 *----------------------------------------------------------------------------------------------------
 * Contact controller used for CRUD operation of Contact Book
 * here are 3 cases
 * 1]submit_new_contact
 * 2]delete_contact
 * 3]update_contact
 * according to user input controller do operation and gives response back to user
 *----------------------------------------------------------------------------------------------------
 */
$returnArr = array();
if ($_SESSION["userEmail"] != "") {
    if (!empty($_POST)) {

        //printArr($_FILES);die;
        $Contact = new Contact();
        $operation = cleanQuery($_POST["operation"]);
        $user_id = $_SESSION['userId'];

        switch ($operation) {
            case "submit_new_contact":

                $email = cleanQuery($_POST["inputEmail"]);
                $fname = cleanQuery($_POST["first_name"]);
                $mname = cleanQuery($_POST["middle_name"]);
                $lname = cleanQuery($_POST["last_name"]);
                $moblie_number = cleanQuery($_POST["moblie_number"]);
                $landline_number = cleanQuery($_POST["landline_number"]);
                $Note = cleanQuery($_POST["Note"]);

                if ($_FILES["photo_path"]["name"]!="") {
                    $file_ext = strtolower(end(explode('.', $_FILES["photo_path"]['name'])));
                    $file_name = strtotime(date("d-m-y h:i:s a")) . "." . $file_ext;
                }else{
                    $file_name="";
                }

                $Contact->commonValidations($email, $fname, $lname, $moblie_number, $landline_number,"photo_path");

                $result = $Contact->submitContactData($email, $fname, $mname, $lname, $moblie_number, $landline_number, $Note, $file_name, $user_id);

                if (noError($result)) {
                    $returnArr["errCode"] = "-1";
                    $returnArr["errMsg"] = "Contact Data Saved Successfully.";
                } else {
                    $returnArr["errCode"] = "1";
                    $returnArr["errMsg"] = "Oop's there is error while adding contact, please try again.";
                }

                break;

            case "delete_contact":
                $contact_id = cleanQuery($_POST["contact_id"]);
                $result = $Contact->deleteContact($contact_id);
                if (noError($result)) {
                    $returnArr["errCode"] = "-1";
                    $returnArr["errMsg"] = "Contact Data Saved Successfully.";
                } else {
                    $returnArr["errCode"] = "1";
                    $returnArr["errMsg"] = "Oop's there is error while adding contact, please try again.";
                }
                break;

            case "update_contact":
                $contact_id = cleanQuery($_POST["edit_id"]);

                $email = cleanQuery($_POST["edit_inputEmail"]);
                $fname = cleanQuery($_POST["edit_first_name"]);
                $mname = cleanQuery($_POST["edit_middle_name"]);
                $lname = cleanQuery($_POST["edit_last_name"]);
                $moblie_number = cleanQuery($_POST["edit_moblie_number"]);
                $landline_number = cleanQuery($_POST["edit_landline_number"]);
                $Note = cleanQuery($_POST["edit_Note"]);

                if ($_FILES["edit_photo_path"]["name"]!="") {
                    $file_ext = strtolower(end(explode('.', $_FILES["edit_photo_path"]['name'])));
                    $file_name = strtotime(date("d-m-y h:i:s a")) . "." . $file_ext;
                }else{
                    $file_name="";
                }

                $Contact->commonValidations($email, $fname, $lname, $moblie_number, $landline_number,"edit_photo_path");

                $result = $Contact->updateContact($contact_id,$fname,$mname,$lname,$moblie_number,$landline_number,$email,$Note,$file_name);
                if (noError($result)) {
                    $returnArr["errCode"] = "-1";
                    $returnArr["errMsg"] = "Contact Data Updated Successfully.";
                } else {
                    $returnArr["errCode"] = "1";
                    $returnArr["errMsg"] = "Oop's there is error while Updating contact, please try again.";
                }
                break;
        }

    } else {
        $returnArr["errCode"] = "1";
        $returnArr["errMsg"] = "Invalid Details please enter proper inputs.";
    }
} else {
    $returnArr["errCode"] = "1";
    $returnArr["errMsg"] = "Unauthorised .";
}
echo json_encode($returnArr, true);
?>