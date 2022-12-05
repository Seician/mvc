<?php
        require '../model/users.php';
        session_start();             
        $usersSess=isset($_SESSION['userSess'])?unserialize($_SESSION['userSess']):new users();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="../libs/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update users</h2>
                    </div>
                    <p>Please fill this form and submit to add users record in the database.</p>
                    <form action="../index.php?act=update" method="post" >
                        <div class="form-group <?php echo (!empty($usersSess->fn_msg)) ? 'has-error' : ''; ?>">
                            <label>First name</label>
                            <input type="text" name="firstname" class="form-control" value="<?php echo $usersSess->firstname; ?>">
                            <span class="help-block"><?php echo $usersSess->fn_msg;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($usersSess->ln_msg)) ? 'has-error' : ''; ?>">
                            <label>Last name</label>
                            <input type="text" name="lastname" class="form-control" value="<?php echo $usersSess->lastname; ?>">
                            <span class="help-block"><?php echo $usersSess->ln_msg;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($usersSess->age_msg)) ? 'has-error' : ''; ?>">
                            <label>Age</label>
                            <input type="text" name="age" class="form-control" value="<?php echo $usersSess->age; ?> ">
                            <span class="help-block"><?php echo $usersSess->age_msg;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $usersSess->id; ?>"/>
                        <input type="submit" name="updatebtn" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>