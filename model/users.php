<?php

class users
{
    // table fields
    public $id;
    public $firstname;
    public $lastname;
    public $age;
    // message string
    public $id_msg;
    public $fn_msg;
    public $ln_msg;
    public $age_msg;

    //search string
    public $search_str;

    // constructor set default value
    function __construct()
    {
        $id=0;$firstname=$lastname="";$age=0;
        $id_msg=$fn_msg=$ln_msg=$age_msg="";
        $search_str="";
    }
}

?>