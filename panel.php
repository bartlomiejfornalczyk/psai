<?php
ob_start();
   require_once("setup.php");
   require_once("functions.php");
   if($_SESSION["logged"] == false)
   {
      // echo "x";
   header("location: index.php");
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.css">
      <link rel="stylesheet" href="style.css">
      <link rel="shortcut icon" href="powershell.png" type="image/x-icon">
      <title>PowerShell App Downloader&Installer</title>
      <meta name="description" content="PHP generator for Powershell to download and install apps in the background (silent mode)">
   </head>
   <body class="main container-fluid">
      <div class="col-md-4">
         <div class="row ">
            <div class="col-md-10">
               <div class="card card-outline-secondary">
                  <div class="card-header">
                     <p class="mb-0">Add new program</p>
                  </div>
                  <div class="card-body">
                     <form autocomplete="off" class="form" role="form" method="POST" action="#">
                        <div class="form-group">
                           <label for="inputName">Program name</label> 
                           <input class="form-control" id="inputName" type="text" name="programName" required>
                        </div>
                        <div class="form-group">
                           <label for="category">Category</label> 
                           <select class="form-control" name="category" size="0" required>
                           <option value="" disabled selected hidden>Select category</option>
                           <?php
                              getCategories($conn);
                           ?>
                              </select>
                        </div>
                        <div class="form-group">
                           <label for="download">Direct link to download file</label> 
                           <input class="form-control" id="download" placeholder="Paste link here" required type="text" name="download"> 
                        </div>
                        <div class="form-group">
                           <label for="fileType">File type</label> 
                           <select class="form-control" name="fileType" size="0" required>
                           <option value="" disabled selected hidden>Select type</option>
                              <option value="1">
                                 exe
                              </option>
                              <option value="2">
                                 msi
                              </option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="switch">Optional switches (arguments)</label> 
                           <input class="form-control" id="switch" placeholder="For example /verysilent /defaultbrowser" required type="text" name="switch"> 
                        </div>
                        <div class="form-group">
                           <button class="btn btn-success btn-lg float-right" type="submit" name="addProgram">Add</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-10">
               <div class="card card-outline-secondary">
                  <div class="card-header">
                     <p class="mb-0">New category</p>
                  </div>
                  <div class="card-body">
                     <form autocomplete="off" class="form" role="form" method="POST" action="#">
                        <div class="form-group">
                           <label for="inputName">Category</label> 
                           <input class="form-control" id="inputName" placeholder="New category" name="newCategory" type="text">
                        </div>
                        <div class="form-group">
                           <button class="btn btn-success btn-lg float-right" type="submit" name="addCategory">Add</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="row ">
            <div class="col-md-10">
               <div class="card card-outline-secondary">
                  <div class="card-header">
                     <p class="mb-0">Remove program</p>
                  </div>
                  <div class="card-body">
                     <form autocomplete="off" class="form" role="form" method="POST" action="#">
                        <div class="form-group">
                           <label for="programs">Select to remove</label> 
                           <select class="form-control" name="program" size="0">
                           <option value="" disabled selected hidden>Select program</option>
                              <?php getPrograms($conn);?>
                           </select>
                        </div>
                        <div class="form-group">
                           <button class="btn btn-success btn-lg float-right" type="submit" name="removeProgram">Remove</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
      <div class="col-md-6">
         <!-- <div class="row"> -->
         <form action="#" method="POST" class="row">
         <?php 
         showPrograms($conn);
         
         ?>
            <div class="form-group">
                           <button class="btn btn-success btn-lg float-right create" type="submit" name="send">Create script</button>
            </div>
            
            </form>
            

      </div>

    <script src="main.js"></script>
   </body>
</html>
<?php

if(isset($_POST['addProgram']))
{
    $programName = $_POST['programName'];
    $category = $_POST['category'];
    $download = $_POST['download'];
    $fileType = $_POST['fileType'];
    $switch = $_POST['switch'];
    $stmt = $conn->prepare("insert into program(name, url, category_id, type_id, switch) values(?,?,?,?,?)");
    $stmt->bind_param('ssiis',$programName,$download,$category,$fileType,$switch);
    $stmt->execute();
    header("location: panel.php");
}
if(isset($_POST['addCategory']))
{
    $category = $_POST['newCategory'];
    $stmt = $conn->prepare("insert into category(name) values(?)");
    $stmt->bind_param('s',$category);
    $stmt->execute();
    header("location: panel.php");
}
if(isset($_POST['removeProgram']))
{
    $remove = $_POST['program'];
    $stmt = $conn->prepare("delete from program where program.id = ?");
    $stmt->bind_param('i',$remove);
    $stmt->execute();
    header("location: panel.php");
}
   if(isset($_POST['send']))
   {
      $programs = $_POST["program"];
      createScript($programs, $conn);   
      echo '<a href="#" id="downloadLink" class="btn btn-info btn-lg float-right download" onclick="downloadMe()">Download</a>';
      echo "<script>
      function downloadMe(filename, elId, mimeType) {
      var elHtml = document.getElementById(elId).innerHTML;
      var link = document.createElement('a');
      mimeType = mimeType || 'text/plain';
      
      link.setAttribute('download', filename);
      link.setAttribute('href', 'data:' + mimeType  +  ';charset=utf-8,' + encodeURIComponent(elHtml));
      link.click(); 
      }
      
      var fileName =  'programs.ps1'; // You can use the .txt extension if you want
      
      document.querySelector('#downloadLink').addEventListener('click', function(){
      downloadMe(fileName, 'script','text/plain');
      let x = window.location.href.slice(0,-1);
      window.location.replace(x);
      });
      </script>";
   }
   ?>