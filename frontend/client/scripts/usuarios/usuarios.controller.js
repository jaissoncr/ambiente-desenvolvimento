(function(){
    'use strict';

    angular.module('app.usuarios')
        .controller('BloqueioUsuariosCtrl', [
            '$scope', '$filter', 'usuarios', 'usuariosAPI', 'logger',
            function($scope, $filter, usuarios, usuariosAPI, logger) {
                $scope.usuarios = usuarios.data;
                $scope.savingUser = false;
                $scope.buttonAddUser = 'Adicionar';
                $scope.searchKeywords = '';
                $scope.filteredRows = [];
                $scope.row = '';

                $scope.select = function(page){
                    var start = (page - 1) * $scope.numPerPage;
                    var end = start + $scope.numPerPage;
                    $scope.currentPageRows = $scope.filteredRows.slice(start, end);
                    //console.log start
                    //console.log end
                    //console.log $scope.currentPageRows
                };

                // on page change: change numPerPage, filtering string
                $scope.onFilterChange = function(){
                    $scope.select(1);
                    $scope.currentPage = 1;
                    $scope.row = '';
                };

                $scope.onNumPerPageChange = function(){
                    $scope.select(1);
                    $scope.currentPage = 1;
                };

                $scope.onOrderChange = function(){
                    $scope.select(1);
                    $scope.currentPage = 1;
                };

                $scope.search = function(){
                    $scope.filteredRows = $filter('filter')($scope.usuarios, $scope.searchKeywords);
                    $scope.onFilterChange();
                };

                // orderBy
                $scope.order = function(rowName){
                    if($scope.row === rowName) {
                        return;
                    }

                    $scope.row = rowName;
                    $scope.filteredRows = $filter('orderBy')($scope.usuarios, rowName);
                    // console.log($scope.filteredRows);
                    $scope.onOrderChange();
                };

                // pagination
                $scope.numPerPageOpt = [3, 5, 10, 20];
                $scope.numPerPage = $scope.numPerPageOpt[1];
                $scope.currentPage = 1;
                $scope.currentPageRows = [];

                // init
                var init = function(){
                    $scope.search();
                    $scope.select($scope.currentPage);
                };
                init();

                // Add User
                $scope.addUser = function(user){
                    $scope.savingUser = true;
                    $scope.buttonAddUser = 'Aguarde...';
                    usuariosAPI.saveUsuario(user.store_id).success( function(){
                        usuariosAPI.getUsuarios().success(function(data){
                            $scope.usuarios = data;
                            $scope.buttonAddUser = 'Adicionar';
                        })['finally'] ( function() {
                            delete $scope.novoUsuario;
                            $scope.savingUser = false;
                            logger.logSuccess('Usuário adicionado com sucesso!');
                            init();
                        });

                        return;
                    });
                };

                // Remove User

                $scope.changeStatus = function(user){
                    if (user.pivot.status === 1){
                        return usuariosAPI.block(user.store_id);
                    }

                    return usuariosAPI.unlock(user.store_id);
                };

                $scope.setSavingUser = function(status){
                    $scope.savingUser = status;
                };

                $scope.logSuccess = function(message){
                    logger.logSuccess(message);
                };


                $scope.logError = function(message){
                    logger.logError(message);
                };

            }
        ])

        .controller('ModalAjudaBloqueioCtrl', [
            '$scope', '$uibModal', '$log',
            function($scope, $uibModal){
                $scope.open = function(size){
                    $uibModal.open({
                        templateUrl: 'views/bloqueio-usuarios/ajuda-bloqueio.html',
                        controller: 'ModalAjudaBloqueioInstanceCtrl',
                        size: size
                    });

                    return;
                };

                return;
            }
        ])

        .controller('ModalAjudaBloqueioInstanceCtrl', [
            '$scope', '$uibModalInstance',
            function($scope, $uibModalInstance){
                $scope.ok = function(){
                    $uibModalInstance.close();
                    return;
                };

                $scope.cancel = function(){
                    $uibModalInstance.close();
                    return;
                };

                return;
            }
        ])
        ;

})();
