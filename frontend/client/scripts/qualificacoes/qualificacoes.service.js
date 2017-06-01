(function () {
    'use strict';

    function qualificacoesAPI($http, config){
        var _get = function(){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/qualificacoes.index.json') :
                $http.get(config.baseUrl + '/qualificacoes');
        };
        
        var _delete = function(id) {
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/qualificacoes.delete.json', {id: id}) :
                $http.delete(config.baseUrl + '/qualificacoes/' + id);
        };
        
        var _disable = function(id){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/qualificacoes.disable.json', {id: id}) :
                $http.post(config.baseUrl + '/qualificacoes', {id: id});
        };

        var _enable = function(id){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/qualificacoes.enable.json', {id: id}) :
                $http.post(config.baseUrl + '/qualificacoes/' + id);
        };

        return {
            get: _get,
            delete: _delete,
            disable: _disable,
            enable: _enable
        };
    }

    angular.module('app.qualificacoes')
        .factory('qualificacoesAPI', [ '$http', 'config', qualificacoesAPI ])
    ;
})();
