<?php
    require 'model/usersModel.php';
    require 'model/users.php';
    require_once 'config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class usersController
	{

 		function __construct() 
		{          
			$this->objconfig = new config();
			$this->objsm =  new usersModel($this->objconfig);
		}
        // mvc handler request
		public function mvcHandler() 
		{
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;

			switch ($act) 
			{
                case 'add' :                    
					$this->insert();
					break;						
				case 'update':
					$this->update();
					break;				
				case 'delete' :					
					$this ->delete();
					break;
                case 'search' :
                    $this->search();
                    break;
				default:
                    $this->list();
			}
		}		
        // page redirection
		public function pageRedirect($url)
		{
			header('Location:'.$url);
		}	
        // check validation
		public function checkValidation($usersSess)
        {    $noerror=true;
            // Validate firstname
            if(empty($usersSess->firstname)){
                $usersSess->fn_msg = "Field is empty.";$noerror=false;
            } else{$usersSess->fn_msg ="";}

            // Validate lastname
            if(empty($usersSess->lastname)){
                $usersSess->ln_msg = "Field is empty.";$noerror=false;
            } else{$usersSess->ln_msg ="";}

            //validate age
            if(empty($usersSess->age)){
                $usersSess->age_msg = "Field is empty.";$noerror=false;
            }else{$usersSess->age_msg ="";}

            return $noerror;
        }
        // add new record
		public function insert()
		{
            try{
                $usersSess=new users();
                if (isset($_POST['addbtn'])) 
                {   
                    // read form value
                    $usersSess->firstname = trim($_POST['firstname']);
                    $usersSess->lastname = trim($_POST['lastname']);
                    $usersSess->age = trim($_POST['age']);
                    //call validation
                    $chk=$this->checkValidation($usersSess);                    
                    if($chk)
                    {   
                        //call insert record            
                        $pid = $this->objsm->insertRecord($usersSess);
                        if($pid){
                            $this->list();
                        }else{
                            echo "Somthing is wrong..., try again.";
                        }
                    }else
                    {    
                        $_SESSION['userSess']=serialize($usersSess);//add session obj           
                        $this->pageRedirect("view/insert.php");                
                    }
                }
            }catch (Exception $e) 
            {
                $this->objsm->close_db();
                throw $e;
            }
        }
        // update record
        public function update()
		{
            try
            {
                
                if (isset($_POST['updatebtn'])) 
                {
                    $usersSess=unserialize($_SESSION['userSess']);
                    $usersSess->id = trim($_POST['id']);
                    $usersSess->firstname = trim($_POST['firstname']);
                    $usersSess->lastname = trim($_POST['lastname']);
                    $usersSess->age = trim($_POST['age']);
                    // check validation  
                    $chk=$this->checkValidation($usersSess);
                    if($chk)
                    {
                        $res = $this -> objsm ->updateRecord($usersSess);	                        
                        if($res){			
                            $this->list();                           
                        }else{
                            echo "Somthing is wrong..., try again.";
                        }
                    }else
                    {         
                        $_SESSION['userSess']=serialize($usersSess);      
                        $this->pageRedirect("view/update.php");                
                    }
                }elseif(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
                    $id=$_GET['id'];
                    $result=$this->objsm->selectRecord($id);
                    $row=mysqli_fetch_array($result);  
                    $usersSess=new users();
                    $usersSess->id=$row["id"];
                    $usersSess->firstname=$row["firstname"];
                    $usersSess->lastname=$row["lastname"];
                    $usersSess->age = $row['age'];
                    $_SESSION['userSess']=serialize($usersSess);
                    $this->pageRedirect('view/update.php');
                }else{
                    echo "Invalid operation.";
                }
            }
            catch (Exception $e) 
            {
                $this->objsm->close_db();
                throw $e;
            }
        }
        // delete record
        public function delete()
		{
            try
            {
                if (isset($_GET['id'])) 
                {
                    $id=$_GET['id'];
                    $res=$this->objsm->deleteRecord($id);                
                    if($res){
                        $this->pageRedirect('index.php');
                    }else{
                        echo "Somthing is wrong..., try again.";
                    }
                }else{
                    echo "Invalid operation.";
                }
            }
            catch (Exception $e) 
            {
                $this->objsm->close_db();
                throw $e;
            }
        }

        public function search() {
            if (isset($_GET['q'])) {
                $k = $_GET['q'];
                $result = $this->objsm->searchRecords($k);
                include "view/search.php";
            }
                else {
                    echo "Invalid action";
                }

        }
        public function list(){
            $result=$this->objsm->selectRecord(0);
            include "view/list.php";                                        
        }
    }
		
	
?>