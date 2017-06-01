(function () {
    'use strict';

    function vendasAPI($http, config){
        var _get = function(){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/vendas.index.json') :
                $http.get(config.baseUrl + '/vendas');
        };
        
        var _add = function(data){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/vendas.index.json') :
                $http.post(config.baseUrl + '/vendas', data);
        };
        
        var _delete = function(id) {
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/vendas.delete.json', {id: id}) :
                $http.delete(config.baseUrl + '/vendas/' + id);
        };

        return {
            get: _get,
            add: _add,
            delete: _delete
        };
    }

    angular.module('app.vendas')
        .factory('vendasAPI', [ '$http', 'config', vendasAPI ])
    ;
})();
