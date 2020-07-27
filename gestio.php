<?php
//Made by Carles Brunet

include_once('./functions/main_functions.php');
include('./functions/vCards.php');
$vCard = new vCard('./vCard.vcf');
session_start();

if (!empty($_SESSION['loggedin'])) {
   


} else{
    header("Location: login.php"); //If user isn't logged in then redirect him to login page
    die();
}

if( isset($_GET['submit']) )
{
    //be sure to validate and clean your variables
    $newTaskTitle = htmlentities($_GET['title']);
    $newTaskDescription = htmlentities($_GET['description']);
    $newTaskUserAssigned = htmlentities($_GET['user_assigned']);
    $newTaskEndDate = htmlentities($_GET['end_date']);
    $newTaskStartDate = date('Y-m-d');

    //then you can use them in a PHP function. 
    $result = createTask($newTaskTitle, $newTaskDescription, $newTaskUserAssigned, $newTaskEndDate, $newTaskStartDate);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>
        <? echo($pageTitle) ?> -
        <? echo($appName) ?>
    </title>
    <link href="dist/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous">
    </script>
   
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.html"><?php echo($appName) ?> - <?php echo count($vCard)?></a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">


            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Principal</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Inici
                        </a>



                        <div class="sb-sidenav-menu-heading">Gestió de tasques</div>
                        <a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-ol	"></i></div>
                            Tasques
                        </a>
                        <a class="nav-link" href="charts.html">

                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Avisos
                        </a>
                        <div class="sb-sidenav-menu-heading">Facturació</div>
                        <a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-invoice	"></i></div>
                            Factures
                        </a>
                        <a class="nav-link" href="charts.html">

                            <div class="sb-nav-link-icon"><i class="fas fa-file-invoice	"></i></div>
                            Rebuts
                        </a>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Sessió iniciada com:</div>
                    <? echo($_SESSION["name"]) ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">
                        <? echo($pageTitle) ?>
                    </h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4" data-toggle="modal"
                                data-target="#exampleModalCenter">
                                <div class="card-body">
                                    <h1>
                                        +
                                    </h1>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">Afegir tasca</a>

                                </div>
                            </div>
                        </div>


 <!-- Modal -->
 <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                            <? echo($editObjectTitle) ?>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">


                                        <form>
                                            <div class="form-group">
                                                <label for="taskTitleInput">Títol de la tasca</label>
                                                <input type="text" class="form-control" id="taskTitleInput"
                                                    placeholder="Títol" name="title">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Usuari assignat</label>
                                                <select class="form-control" id="exampleFormControlSelect1"
                                                    name="user_assigned">
                                                    <option value="carlesbrunet">Carles Brunet</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Descripció</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                                    name="description"></textarea>
                                            </div>
                                            <input type="date" class="form-control" id="taskTitleInput"
                                                placeholder="Data de finalització" name="end_date">

                                            <?php
$keys = array('page');
foreach($keys as $name) {
  if(!isset($_GET[$name])) {
    continue;
  }
  $value = htmlspecialchars($_GET[$name]);
  $name = htmlspecialchars($name);
  echo '<input type="hidden" name="'. $name .'" value="'. $value .'">';
}
?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Descartar</button>
                                        <button type="submit" name="submit2" class="btn btn-primary">Desar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                            <? echo($editObjectTitle) ?>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">


                                        <form>
                                            <div class="form-group">
                                                <label for="taskTitleInput">Títol de la tasca</label>
                                                <input type="text" class="form-control" id="taskTitleInput"
                                                    placeholder="Títol" name="title">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Usuari assignat</label>
                                                <select class="form-control" id="exampleFormControlSelect1"
                                                    name="user_assigned">
                                                    <option value="carlesbrunet">Carles Brunet</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Descripció</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                                    name="description"></textarea>
                                            </div>
                                            <input type="date" class="form-control" id="taskTitleInput"
                                                placeholder="Data de finalització" name="end_date">

                                            <?php
$keys = array('page');
foreach($keys as $name) {
  if(!isset($_GET[$name])) {
    continue;
  }
  $value = htmlspecialchars($_GET[$name]);
  $name = htmlspecialchars($name);
  echo '<input type="hidden" name="'. $name .'" value="'. $value .'">';
}
?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Descartar</button>
                                        <button type="submit" name="submit" class="btn btn-primary">Desar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Tasques pendents
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Títol de la tasca</th>
                                            <th>Descripció</th>
                                            <th>Usuari assignat</th>
                                            <th>Data de finalització</th>
                                            <th>Accions</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Títol de la tasca</th>
                                            <th>Descripció</th>
                                            <th>Usuari assignat</th>
                                            <th>Data de finalització</th>
                                            <th>Accions</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php

listTasques();

?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">
                            <? getFooter(); ?>
                        </div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="dist/js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="dist/assets/demo/datatables-demo.js"></script>
     <script type="text/javascript">
        $('.editTask').on('click', function () {
            var $item = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".nr")     // Gets a descendent with class="nr"
                       .text();    
            $('.modal-body').load('gestio.php?editId=', function () {
                    // Retrieves the text within <td>

    $("#editModal").append($item); 
                $('#editModal').modal({
                    show: true
                });
            });
        });
    </script>
</body>

</html>