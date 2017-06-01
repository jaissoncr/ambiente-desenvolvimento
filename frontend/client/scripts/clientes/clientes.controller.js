(function(){
    'use strict';

    angular.module('app.clientes')
    
        .controller('ClientesCtrl', [
            '$scope', '$filter', '$window', 'clientes', 'clientesAPI', 'logger',
            function($scope, $filter, $window, clientes, clientesAPI, logger){
            $scope.clientes = clientes.data;
            $scope.searchKeywords = '';
            $scope.filteredRows = [];
            $scope.row = '';
           
            
            // Select Cliente
            $scope.isClienteSelected = function (clientes){
                return clientes.some(function (cliente){
                    return cliente.selected;
                });
            };
            
            // Add Cliente
            $scope.save = function(cliente){
                clientesAPI.add(cliente).success(function(data){
                    if (cliente.id === undefined) 
                        logger.logSuccess('Cliente adicionado com sucesso');
                    else 
                        logger.logSuccess('Cliente atualizado com sucesso');
                    cliente.id = $scope.clientes.length + 1;
                    $scope.clientes.push(cliente);
                    delete $scope.cliente;
                    $window.location.href = '#/clientes';
                });
            };
            
            
            // Edit Cliente
            $scope.edit = function(cliente){
                $window.location.href = '#/editar-cliente';
                //cliente.selected);
            };
            
            // Remove Cliente
            $scope.remove = function (cliente){
            var index;
                clientesAPI.delete(cliente).success(function(data) {
                   index = $scope.clientes.indexOf(cliente);
                   $scope.clientes.splice(index, 1);
                   $scope.clientes.selected$pristine;
                   logger.log('Cliente removido!');
                   init();
                });
            };
            
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
                $scope.filteredRows = $filter('filter')($scope.clientes, $scope.searchKeywords);
                $scope.onFilterChange();

            };

            // orderBy
            $scope.order = function(rowName){
                if($scope.row === rowName) {
                    return;
                }

                $scope.row = rowName;
                $scope.filteredRows = $filter('orderBy')($scope.clientes, rowName);
                //console.log($scope.filteredRows);
                $scope.onOrderChange();
            };

            // pagination
            $scope.numPerPageOpt = [3, 5, 10, 20, 50];
            $scope.numPerPage = $scope.numPerPageOpt[2];
            $scope.currentPage = 1;
            $scope.currentPageRows = [];

            // init
            var init = function(){
                $scope.search();
                $scope.select($scope.currentPage);
            };
            init();
            
        }
        ]);
})();
