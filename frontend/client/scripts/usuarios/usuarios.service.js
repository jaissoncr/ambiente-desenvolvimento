(function () {
    'use strict';

    function usuariosAPI($http, config){
        var _getUsuarios = function(){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/user.find.json') :
                $http.get(config.baseUrl + '/usuarios');
        };

        var _saveUsuario = function(id){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/user.find.json', {id: id}) :
                $http.post(config.baseUrl + '/usuarios', {id: id});
        };

        var _block = function(id){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/user.block.json', {id: id}) :
                $http.post(config.baseUrl + '/blockUser', {id: id});
        };

        var _unlock = function(id){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/user.unlock.json', {id: id}) :
                $http.delete(config.baseUrl + '/unlockUser/' + id);
        };

        return {
            getUsuarios: _getUsuarios,
            saveUsuario: _saveUsuario,
            block: _block,
            unlock: _unlock
        };
    }

    angular.module('app.usuarios')
        .factory('usuariosAPI', [ '$http', 'config', usuariosAPI ])
    ;
})();
