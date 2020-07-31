<?php
//Made by Carles Brunet

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
    $createObjectTitle = 'Crear nova tasca'; 
    $editObjectTitle = 'Editar tasca';  
} elseif ($_GET["page"] == 'factures'){
    $appName = 'M3dH4x Task Manager';
    $pageTitle = 'Factures';
}


if (isset($_POST['idEditTask'])){
  $idForEdit =   editTask($_REQUEST['idEditTask']);
  echo $idForEdit;


}

function listMails() {
  $vCard = new vCard('./vCard.vcf');
  if (count($vCard) == 1)
  {
      
      print_r($vCard -> tel);
  }
  
  else
  {
      foreach ($vCard as $vCardPart)
      {
          
          if ($vCardPart -> email){
            print_r($vCardPart -> email);
          }
      }
  }
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

function editTask($paramRowNumb){
$editTaskId = $paramRowNumb;
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

$resultado = mysqli_query($db,"SELECT id, title, description, user_assigned, end_date FROM tasks WHERE id = '$editTaskId' ");

$keys = array('page');

if ($resultado->num_rows >  0) {
// output data of each row
while($row = $resultado ->fetch_assoc()) {
  echo <<<EOT
                                          
                                          
                    
                    
  <form>
  <div class="form-group">
  <label for="newTaskIdInput">Identificador de la tasca</label>

  <input type="text" class="form-control" id="newTaskIdInput"
              placeholder="Identificador" value="$row[id]" name="id" readonly>
</div>

      <div class="form-group">
          <label for="newTaskTitleInput">Títol de la tasca</label>
          <input type="text" class="form-control" id="newTaskTitleInput"
              placeholder="Títol" value="$row[title]" name="title">
      </div>
      <div class="form-group">
          <label for="newTaskUserAssignedInput">Usuari assignat</label>
          <select class="form-control" value="$row[user_assigned]" id="newTaskUserAssignedInput"
              name="user_assigned"required>
              <option value="carlesbrunet">Carles Brunet</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
          </select>
      </div>

      <div class="form-group">
          <label for="newTaskDescriptionInput">Descripció</label>
          <textarea class="form-control" id="newTaskDescriptionInput"  rows="3"
              name="description"required>$row[description]</textarea>
      </div>
      <input type="date" class="form-control" id="newEndTaskInput"
          placeholder="Data de finalització" value="$row[end_date]" name="end_date"required>
          </div>
          <input type="hidden" name="page" value="tasks">
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary"
                  data-dismiss="modal">Descartar</button>
              <button type="submit" name="submit2" class="btn btn-primary">Desar edició</button>
             
              </form>




EOT;






    
  
}
} else {
echo "0 results";
}

};

function listTasquesNoButton(){
  $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

  $resultado = mysqli_query($db,"SELECT id, title, description, user_assigned, end_date FROM tasks WHERE user_assigned = '$_SESSION[username]' ");


if ($resultado->num_rows >  0) {
  // output data of each row
  while($row = $resultado ->fetch_assoc()) {
  echo  
      '<tr id="'.$row['id'].'">' .
      '<td>' .$row["title"].'</td>'.
      '<td>'.$row["description"].'</td>'.
      '<td>'.$row["user_assigned"].'</td>'.
      '<td>'.$row["end_date"].'</td>'
    
     .' </tr>';
             
    
  }
} else {
  echo "0 results";
}
}
function listTasques(){
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    $resultado = mysqli_query($db,"SELECT id, title, description, user_assigned,start_date, end_date FROM tasks WHERE user_assigned = '$_SESSION[username]' ");


if ($resultado->num_rows >  0) {
    // output data of each row
    while($row = $resultado ->fetch_assoc()) {
  

       echo  
       '<div class="card text-center" style="width: 18rem;margin: 10px;display:inline-block;">
       <div id="'.$row['id'].'" class="card-body">
         <h5 class="card-title">'.$row['title'].'</h5>
         <p class="card-text">'.$row['start_date'].' / '.$row['end_date'].'</p>
         <p class="card-text">'.$row['description'].'</p>

         <button type="button"  class="btn btn-primary editTask">Editar</button>
        
         <button type="button" class="btn btn-danger">Eliminar</button>
       </div>
     </div>';
               
      
    }
  } else {
    echo "0 results";
  }
}
function createTask($title, $description, $user_assigned,$end_date,$start_date){
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

    $result = mysqli_query($db, "INSERT INTO tasks(title,description,user_assigned,end_date,start_date) VALUES ('$title','$description', '$user_assigned','$end_date','$start_date')");
  


}
function saveEditedTask($id, $title, $description, $user_assigned,$end_date,$start_date){
  $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

  $result = mysqli_query($db, "UPDATE tasks SET title = '$title', description = '$description', user_assigned = '$user_assigned', end_date = '$end_date', start_date = '$start_date' WHERE id = '$id';");



}
function getFooter() {
    echo 'Copyright &copy; Carles Brunet 2020';
}

?>

