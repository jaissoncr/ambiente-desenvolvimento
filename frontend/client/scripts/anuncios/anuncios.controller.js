(function(){
    'use strict';

    angular.module('app.anuncios')

        .controller('anunciosCtrl', [
            '$scope', '$filter', 'anuncios', 'anunciosAPI', 'logger',
            function($scope, $filter, anuncios, anunciosAPI, logger) {
                $scope.anuncios = anuncios.data;
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
                    $scope.filteredRows = $filter('filter')($scope.anuncios, $scope.searchKeywords);
                    $scope.onFilterChange();
                };

                // orderBy
                $scope.order = function(rowName){
                    if($scope.row === rowName) {
                        return;
                    }

                    $scope.row = rowName;
                    $scope.filteredRows = $filter('orderBy')($scope.anuncios, rowName);
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

                $scope.logSuccess = function(message){
                    logger.logSuccess(message);
                };

                $scope.logError = function(message){
                    logger.logError(message);
                };

            }

        ]);
})();
