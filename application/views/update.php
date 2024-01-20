<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update task</title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('images/favicon1.png');?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top">
        <div class="container-fluid">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class=" navbar-brand" href="home"><img src="<?php echo base_url('images/home.png');?>" style="width:40px; height:auto" alt="Home"></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:#E74E35; font-size:20px;" href="home"><b>Taskify</b></a>
            </li>
            </ul>
        </div>
    </nav><br><br><p></p><br><br>
    <?php
    foreach($task as $row):
    $id= $row['id']; 
    $taskk= $row['task'];
    $status= $row['status'];
    $datetime= $row['created_on']; ?>
    <div class="container-fluid">
        <form action="<?= base_url('update/'.$id); ?>" method="post">
        <div class="container">
        <div class="row">
        <div class="col col-lg col-sm me-2">
            <label class="form-label" for="task" >Task</label>
            <textarea class= "form-control border-#adb5bd" id="task" name="edittask" style="width:320px;height:100px;"><?= $taskk ?></textarea>
        </div>
        <div class="col col-lg col-sm">
            <label class="form-label" for="date" >Created On</label>
            <input type="text" class="form-control border-#adb5bd" id="date" name="datetime" style="width:250px;height:50px;" placeholder="<?= $datetime ?>" readonly>
        </div>
        <div class="col col-lg col-sm">
        <label class="form-label" for="dropdown">Status</label>
        <select class="form-select" name="status" style="width:250px;height:50px;">
        <option value="<?= $status ?>" selected hidden><?= $status ?></option>
        <option>Todo</option>
        <option>In Progress</option>
        <option>Completed</option>
        </select>
        </div>
        </div><br><br>
        <input type="submit" name="save" class="btn" style="width: 150px; background-color:#E74E35; color:white;" value="Save changes">
        </div>
        </form>
    </div>
    <?php endforeach; ?>
</body>
</html>