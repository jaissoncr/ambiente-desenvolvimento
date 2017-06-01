(function(){
    'use strict';

    angular.module('app.vendas')
        .controller('VendasCtrl', [
            '$scope', '$filter', '$window', 'vendas', 'vendasAPI', 'logger',
            function($scope, $filter, $window, vendas, vendasAPI, logger){
            $scope.vendas = vendas.data;
            $scope.searchKeywords = '';
            $scope.filteredRows = [];
            $scope.row = '';
            
            // Select Venda
            $scope.isVendaSelected = function (vendas){
                return vendas.some(function (venda){
                    return venda.selected;
                });
            };
            
            // Add Venda
            $scope.add = function(venda){
                vendasAPI.add(venda).success(function(data){
                    $scope.vendas.push(venda);
                    logger.logSuccess('Venda adicionada com sucesso');
                    console.log($scope.venda);
                    // delete $scope.venda;
                    // $window.location.href = '#/vendas';
                });
            };
            
            // Calcula Total Venda
            $scope.isTotalCalculated = true;
            $scope.totalAmount = 0;
            $scope.updateTotal = updateTotal;
            $scope.venda = '';
            updateTotal(); // initial update of total
            
            function updateTotal(){
               if (!$scope.isTotalCalculated) return;
               $scope.totalAmount = $scope.quantity * $scope.venda.price
            }
            
            // Remove Venda
            $scope.remove = function (venda){
            var index;
                vendasAPI.delete(venda).success(function(data) {
                   index = $scope.vendas.indexOf(venda);
                   $scope.vendas.splice(index, 1);
                   logger.log('Venda removida!');
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
                $scope.filteredRows = $filter('filter')($scope.vendas, $scope.searchKeywords);
                $scope.onFilterChange();

            };

            // orderBy
            $scope.order = function(rowName){
                if($scope.row === rowName) {
                    return;
                }

                $scope.row = rowName;
                $scope.filteredRows = $filter('orderBy')($scope.vendas, rowName);
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
