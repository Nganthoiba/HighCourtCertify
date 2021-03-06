<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * and open the template in the editor.
 */
$user =  $data['user'];
?>

<div class="container-fluid" style="margin: auto">
    
    <form method="POST">
        <div class="row">
            <div class="col-sm-4 mx-auto">
                <h3>Update your profile below:</h3>
                <?= writeCSRFToken() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="control-label" for="full_name">Name:</label>
            </div>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= $user->full_name ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="control-label" for="email">Email address:</label>
            </div>
            <div class="col-sm-4">
                <input type="email" class="form-control" id="email" name="email" value="<?= $user->email ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="control-label" for="phone_number">Mobile Phone No.:</label>
            </div>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= $user->phone_number ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="control-label" for="aadhaar">Aadhaar:</label>
            </div>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="aadhaar" name="aadhaar" value="<?= $user->aadhaar ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="control-label" for="role">User Role:</label>
            </div>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="role" name="role" value="<?= $user->role_name ?>" readonly />
            </div>
        </div>
        <div class="row" style="text-align: center">
            <div class="col-sm-4 mx-auto">
                <button type="submit" class="btn btn-primary">Submit</button>
                <div id="update_response"><?= $data['update_response'] ?></div>
            </div>
        </div>
    </form>
    <!--
    <div class="card">
        <h5 class="card-header default-color white-text py-3">
            <strong>You can update your profile below:</strong>
        </h5>
        <div class="card-body">
            
        </div>
    </div>
    -->      
</div>
