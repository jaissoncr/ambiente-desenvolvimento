(function () {
    'use strict';

    function clientesAPI($http, config){
        var _get = function(){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/clientes.index.json') :
                $http.get(config.baseUrl + '/clientes');
        };
        
         var _add = function(data){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/clientes.index.json') :
                $http.post(config.baseUrl + '/clientes', data);
        };
        
        var _delete = function(id) {
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/clientes.index.json', {id: id}) :
                $http.delete(config.baseUrl + '/clientes/' + id);
        };
        
        var _find = function(id) {
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/clientes.index.json', {id: id}) :
                $http.get(config.baseUrl + '/clientes/' + id);
        };
        

        return {
            get: _get,
            add: _add,
            delete: _delete,
            find: _find
        };
    }

    angular.module('app.clientes')
        .factory('clientesAPI', [ '$http', 'config', clientesAPI ])
    ;
})();
