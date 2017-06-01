(function () {
    'use strict';

    function produtosAPI($http, config){
        var _get = function(){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/produtos.index.json') :
                $http.get(config.baseUrl + '/produtos');
        };
        
        var _add = function(data){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/produtos.index.json') :
                $http.post(config.baseUrl + '/produtos', data);
        };
        
        var _delete = function(id) {
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/produtos.delete.json', {id: id}) :
                $http.delete(config.baseUrl + '/produtos/' + id);
        };

        return {
            get: _get,
            add: _add,
            delete: _delete
        };
    }

    angular.module('app.produtos')
        .factory('produtosAPI', [ '$http', 'config', produtosAPI ])
    ;
})();
