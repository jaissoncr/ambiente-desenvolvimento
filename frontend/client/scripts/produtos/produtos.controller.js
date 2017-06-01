(function(){
    'use strict';

    angular.module('app.produtos')
    
        .controller('ProdutosCtrl', [
            '$scope', '$filter', '$window', 'produtos', 'produtosAPI', 'logger',
            function($scope, $filter, $window, produtos, produtosAPI, logger){
            $scope.produtos = produtos.data;
            $scope.searchKeywords = '';
            $scope.filteredRows = [];
            $scope.row = '';
            
            // Select Produto
            $scope.isProdutoSelected = function (produtos){
                return produtos.some(function (produto){
                    return produto.selected;
                });
            };
            
            // Add Produto
            $scope.add = function(produto){
                produtosAPI.add(produto).success(function(data){
                    $scope.produtos.push(produto);
                    logger.logSuccess('Produto adicionado com sucesso');
                    delete $scope.produto;
                    $window.location.href = '#/produtos';
                });
            };
            
            // Remove Produto
            $scope.remove = function (produto){
            var index;
                produtosAPI.delete(produto).success(function(data) {
                   index = $scope.produtos.indexOf(produto);
                   $scope.produtos.splice(index, 1);
                   $scope.produtos.selected$pristine;
                   logger.log('Produto removido!');
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
                $scope.filteredRows = $filter('filter')($scope.produtos, $scope.searchKeywords);
                $scope.onFilterChange();

            };

            // orderBy
            $scope.order = function(rowName){
                if($scope.row === rowName) {
                    return;
                }

                $scope.row = rowName;
                $scope.filteredRows = $filter('orderBy')($scope.produtos, rowName);
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
