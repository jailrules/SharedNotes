var shareNotes = angular.module('shareNotes', []);

shareNotes.controller('carritocontroller', function ($scope) {
    $scope.estaMenu = true;
    $scope.estaPrincipal = false;

    $scope.mostrar = function () {
        if ($scope.estaMenu === true) {
            $scope.estaMenu = false;
            $scope.estaPrincipal = true;
        }
        else if ($scope.estaMenu === false) {
            $scope.estaMenu = true;
            $scope.estaPrincipal = false;
        }
    };

});