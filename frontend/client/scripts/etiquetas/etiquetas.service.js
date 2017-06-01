(function () {
    'use strict';

    function etiquetasAPI($http, config){
        var _get = function(){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/etiquetas.index.json') :
                $http.get(config.baseUrl + '/etiquetas');
        };

        var _add = function(data){
                return (config.debug === true) ?
                    $http.get(config.baseUrl + '/etiquetas.index.json') :
                    $http.post(config.baseUrl + '/etiquetas', data);
            };

        var _delete = function() {
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/etiquetas.index.json') :
                $http.delete(config.baseUrl + '/etiquetas/');
        };

        var _find = function(id) {
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/etiquetas.index.json', {id: id}) :
                $http.get(config.baseUrl + '/etiquetas/' + id);
        };


        return {
            get: _get,
            add: _add,
            delete: _delete,
            find: _find
        };
    }

    angular.module('app.etiquetas')
        .factory('etiquetasAPI', [ '$http', 'config', etiquetasAPI ])
    ;
})();
