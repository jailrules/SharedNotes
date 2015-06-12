<?php include './php/session.php'; ?>
<?php include './php/php_conexion.php'; ?>
<?php include './php/close_session.php'; ?>
<!DOCTYPE html>
<html lang="es">

    <head>

        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>SharedNotes</title>
        <script src="http://code.angularjs.org/1.2.15/angular.min.js"></script>      

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/simple-sidebar.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Login</h4>
                    </div>

                    <div class="modal-body">
                        <!-- The form is placed inside the body of modal -->
                        <form id="loginForm" method="post" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Username</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5 col-sm-offset-3">
                                    <button type="submit" id="login" name="login" class="btn btn-warning btn-lg" style="width: 100%;" value="login">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="header" class="page-header" style="position: fixed; width: 100%; z-index: 100; background-color: #080808;" title="SharedNotes">
            <div class="row">
                <div id="header_image" class="container-fluid" style="float:left">
                    <h1 style="color: #FFFFFF; padding-left: 90px;"><img  width="62" height="64" alt="logo" border="0" src="src\mmmm.png">SharedNotes</h1>
                </div>
            </div>
            <div id="userlogin">
                <div class="row" style="background-color: #080808;">
                    <?php include './php/user_nav.php'; ?>
                </div>
            </div>
        </div>
        <br><br><br><br><br>
        <div id="wrapper">

            <!-- Sidebar -->
             <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <li>
                        <a href="index.php">Inicio</a>
                    </li>
                    <li>
                        <a href="apuntes.php">Apuntes</a>
                    </li>
                    <li>
                        <a href="material.php">Material</a>
                    </li>           
                </ul>
            </div>
            <!-- /#sidebar-wrapper -->
            <br><br>
            <!-- Page Content -->
            <div id="page-content-wrapper">
                                                            
                        
                        <div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-bookmark"></span> Panel Usuario</h3>
                </div>
                <div class="panel-body">
                    <div class="row text-center">
                        <div class="col-xs-8">
                          <!--<a href="miperfil.php" class="btn btn-danger btn-lg" role="button"><span class="glyphicon glyphicon-list-alt"></span> <br/>Mi Perfil</a>-->
                          <a href="misapuntes.php" class="btn btn-warning btn-lg" role="button"><span class="glyphicon glyphicon-bookmark"></span> <br/>Mis apuntes</a>
                          <a href="gestion_material.php" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-briefcase"></span> <br/>Mis Materiales</a>
                          <!--<a href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-signal"></span> <br/>XXX</a>-->
                          <!--<a href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-comment"></span> <br/>XXX</a>-->
                        </div>
                        
                          <?php
                            if($_SESSION['admin']==true){
                                echo '<div class="col-xs-4">';
                                echo '<td>';
                                echo '<a href="usuarios.php" class="btn btn-info btn-lg" role="button"><span class="glyphicon glyphicon-user"></span> <br/>Administrar Miembros</a>';
                                echo '</td>';
                                echo '</div>';
                            }
                            
                          ?>
                          <!--<a href="#" class="btn btn-info btn-lg" role="button"><span class="glyphicon glyphicon-file"></span> <br/>XXX</a>
                          <a href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-picture"></span> <br/>XXX</a>
                          <a href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-tag"></span> <br/>XXX</a>-->                         
                        
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
                    </div>
                </div>
                <!-- /#page-content-wrapper -->

            </div>
        </div>
        <!-- /#wrapper -->

        <!-- jQuery Version 1.11.0 -->
        <script src="js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        

    </body>
</html>