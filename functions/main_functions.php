<?php
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'medhax-task');

$config['allowed_pages'] = array('home','tasks','invoices','users');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$config['errors'] = array('No se que putes passa');
global $config;

if ( !isset($_GET["page"]) || $_GET["page"] == '' ){
$pageTitle = 'Inici';
$appName = 'M3dH4x Task Manager';


} elseif ($_GET["page"] == 'tasks'){
    $appName = 'M3dH4x Task Manager';
    $pageTitle = 'Tasques';
    $editObjectTitle = 'Crear nova tasca';  
} elseif ($_GET["page"] == 'factures'){
    $appName = 'M3dH4x Task Manager';
    $pageTitle = 'Factures';
}




function getAvisos() {
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    $result = mysqli_query($db, "SELECT * FROM warnings");
  $numAvisos =  $result->num_rows;

   echo ($numAvisos);
};
function getTasques() {
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    $result = mysqli_query($db, "SELECT * FROM tasks WHERE user_assigned = '$_SESSION[username]' ");
  $numAvisos =  $result->num_rows;

   echo ($numAvisos);
};

function listTasques(){
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    $resultado = mysqli_query($db,"SELECT id, title, description, user_assigned, end_date FROM tasks WHERE user_assigned = '$_SESSION[username]' ");


if ($resultado->num_rows >  0) {
    // output data of each row
    while($row = $resultado ->fetch_assoc()) {
      echo 
        '<tr>' .
        '<td>' .$row["title"].'</td>'.
        '<td>'.$row["description"].'</td>'.
        '<td>'.$row["user_assigned"].'</td>'.
        '<td>'.$row["end_date"].'</td>'.
        '<td>'.'<div class="btn-group" style="display: flex;" role="group" aria-label="Basic example">
        <button type="button"  class="btn btn-primary editTask">Editar</button>
        
        <button type="button" class="btn btn-danger">Eliminar</button>
      </div>'.'</td>'
       .' </tr>';
               
      
    }
  } else {
    echo "0 results";
  }
}
function createTask($title, $description, $user_assigned,$end_date,$start_date){
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    $result = mysqli_query($db, "INSERT INTO tasks(title,description,user_assigned,end_date,start_date) VALUES ('$title','$description', '$user_assigned','$end_date','$start_date')");
  


}
function getFooter() {
    echo 'Copyright &copy; Carles Brunet 2020';
}

?>

