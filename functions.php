<?php
require_once('setup.php');

function getCategories($conn)
{
    $result = $conn->query("select id,name from category");
    while($r = $result->fetch_assoc())
    {
        echo "<option value=".$r['id'].">".$r['name']."</option>";
    }

}
function getPrograms($conn)
{
    $result = $conn->query("select id,name from program");
    while($r = $result->fetch_assoc())
    {
        echo "<option value=".$r['id'].">".$r['name']."</option>";
    }

}
function showPrograms($conn)
{
    $category = $conn->query("select name,id from category");
    while($ss = $category->fetch_assoc())
    {
        echo '<div class="col-sm-6 col-md-4 col-xl-4">
        <div class="card">
           <div class="card-header">
              <p class="mb-0">';
              echo $ss['name'];
        echo '</p></div>';
        echo '<div class="card-body">';
        // </div>';
        $result = $conn->query("select program.id as pid ,program.name as pname, category.id as cid from program inner join category on program.category_id = category.id  where program.category_id = ".$ss['id']." order by cid");
        while($r = $result->fetch_assoc())
        {
                      
        echo '<div class="form-check">
              <input class="form-check-input" type="checkbox" name="program[]" value="'.$r['pid'].'" id='.$r['pid'].'><label class="form-check-label" for='.$r['pid'].'>'.$r['pname'].'</label></div>';
        }
        echo '</div></div></div>';
    }
}
function createScript($programs, $conn)
{
    echo '<div id="script">';
    $cmd = "If (!([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]'Administrator')) {
    Write-Host \"You didn't run this script as an Administrator. This script will self elevate to run as an Administrator and continue.\"
    Start-Process powershell.exe -ArgumentList (\"-NoProfile -ExecutionPolicy Bypass -File `\"{0}`\"\" -f \$PSCommandPath) -Verb RunAs
    Exit
    };
    \$wc = new-object System.Net.WebClient;";
    foreach ($programs as $program) {
        $result = $conn->query("select name, url, switch, type.type as type from program inner join type on program.type_id = type.id where program.id = $program");
        $result = $result->fetch_assoc();
        $url = $result['url'];
        $name = $result['name'];
        $type = $result['type'];
        $switch = '';
        if($result['switch'])
        {
            $switch = $result['switch'];
        }
        $cmd .= 'Write-Progress -Activity "Downloading '.$name.'"; ';
        $cmd .= '$wc.DownloadFile("'.$url.'", "C:/'.$name.'.'.$type.'");';
        $cmd .= ' Write-Progress -Activity "Installing '.$name.'"; ';
        if($type == "msi")
        {
            $cmd = $cmd."Start-Process -Filepath 'C:/$name.$type' -ArgumentList '/qn $switch' -PassThru;";
            
        }
        else{
            $cmd = $cmd."Start-Process -Filepath 'C:/$name.$type' -ArgumentList '/silent /S /V /qn /install $switch' -PassThru;";
        }
               
    }
    echo $cmd; 
    echo '</div>';
    $ready = true;
    return $ready;
}