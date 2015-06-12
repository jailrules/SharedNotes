<?php include './php/session.php'; ?>
<?php include './php/php_conexion.php'; ?>
<?php include './php/php_register.php'; ?>
<?php include './php/close_session.php'; ?>
<!DOCTYPE html>
<html lang="es">

    <?php //181114 ?>
    <head>

        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <script src="http://code.angularjs.org/1.2.15/angular.min.js"></script>      


        <title>SharedNotes</title>

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
        <!--Modal Registro-->
        <div class="modal fade" id="ModalRegister" tabindex="-1" role="dialog" aria-labelledby="ModalRegister" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                        <h3 class="modal-title custom_align" id="Heading">Registro de Usuario</h3>
                    </div>
                    <div class="modal-body">
                        <form method="post"  enctype="multipart/form-data">
                             <div class="form-group">
                            <label>Nombre de Usuario</label>
                            <input class="form-control" id="username" name="username" type="text" required>
                        </div>     
                
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" id="email" name="email" type="email" required>                          
                        </div>
                        
                        <div class="form-group">
                            <label>Contrase&ntilde;a</label>
                            <input class="form-control" id="passwd" name="passwd" type="password" required>
                        </div>
                            
                        <div class="form-group">
                            <label>Confirmar Contrase&ntilde;a</label>
                            <input class="form-control" id="confirmpasswd" name="confirmpasswd" type="password" required>
                        </div>
                        
                    </div>
                    <div class="modal-footer ">
                        <button type="submit" id="registrar" name="registrar" value="registrar" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Registrar</button>                        
                    </div>
                     </form> 
                </div>
            </div><!-- /.modal-content -->
        </div> <!-- /.modal-dialog --> 
        <!--Fin Modal Registro-->
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
        <div id="header" class="page-header" style="position: static; font-family: 'Orbitron', sans-serif; width: 100%; z-index: 0; background-color: #080808;" title="SharedNotes">
            <div class="row">
                <div id="header_image" class="container-fluid" style="float:left">
                    <h1 style="color: #FFFFFF; padding-left: 90;"><img  width="62" height="64" alt="logo" border="0" src="src\mmmm.png">SharedNotes</h1>
                </div>
            </div>
            <div id="userlogin" class="row-fluid" style="float: right; position: static; width: 100%; background-color: #080808;">
                <?php include './php/user_nav.php'; ?>
            </div>
        </div>
        <div id="wrapper" style="position: static; z-index: 0;">
            <a href="#menu-toggle" class="btn btn-default" style="background-color: #382F2F; border-width: 0px; position: absolute; top: 50%; left: 110px; z-index: 101;" id="menu-toggle" ng-show="estaMenu" ng-click="mostrar()"><span class="glyphicon glyphicon-chevron-left" style="color: #FFFFFF;"></span></a>
            <!-- Sidebar -->
            <div id="sidebar-wrapper" style="z-index: 0">
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
            <a href="#menu-toggle2" class="btn btn-default" style="position: absolute; margin-top: 50px; background-color: #382F2F; border-width: 0px; top: 50%; left: 0px;" id="menu-toggle2" ng-show="estaPrincipal" ng-click="mostrar()"><span class="glyphicon glyphicon-chevron-right" style="color: #FFFFFF;"></span></a>
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <p>Bienvenido a SharedNotes tu portal de intercambios academicos, donde podrás encontrar tanto apuntes realizados por usuarios del portal como comprar o vender materiales de caracter academico.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery Version 1.11.0 -->
        <script src="js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Menu Toggle Script -->
        <script>

                $("#menu-toggle").click(function (e) {
                    e.preventDefault();
                    $("#menu-toggle").hide();

                    $("#menu-toggle2").show();
                    $("#wrapper").toggleClass("toggled");
                });

                $("#menu-toggle2").click(function (e) {
                    e.preventDefault();
                    $("#menu-toggle2").hide();
                    $("#menu-toggle").show();
                    $("#wrapper").toggleClass("toggled");
                });
        </script>

    </body>
</html>
