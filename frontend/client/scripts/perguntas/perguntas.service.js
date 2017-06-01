(function () {
    'use strict';

    function perguntasAPI($http, config){
        var _get = function(){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/perguntas.index.json') :
                $http.get(config.baseUrl + '/perguntas');
        };
        
        var _getAssinaturas = function(){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/assinaturas.index.json') :
                $http.get(config.baseUrl + '/assinaturas');
        };
        
        var _sendAnswer = function(id) {
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/perguntas.index.json', {id: id}) :
                $http.post(config.baseUrl + '/perguntas/' + id);
        };
            
        var _addAssinatura = function(id){
                return (config.debug === true) ?
                    $http.get(config.baseUrl + '/assinaturas.index.json') :
                    $http.post(config.baseUrl + '/assinaturas' + id);
            };
    
        var _delete = function(id) {
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/perguntas.delete.json', {id: id}) :
                $http.delete(config.baseUrl + '/perguntas/' + id);
        };
        
        var _deleteAssinatura = function() {
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/assinaturas.index.json') :
                $http.delete(config.baseUrl + '/assinaturas/');
        };
        

        return {
            get: _get,
            getAssinaturas: _getAssinaturas,
            sendAnswer: _sendAnswer,
            addAssinatura: _addAssinatura,
            delete: _delete,
            deleteAssinatura: _deleteAssinatura
        };
    }

    angular.module('app.perguntas')
        .factory('perguntasAPI', [ '$http', 'config', perguntasAPI ])
    ;
})();
