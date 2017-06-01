(function () {
    'use strict';

    angular.module('app.task')
        .factory('tasksAPI', [ '$http', 'config', function($http, config){
            var _get = function() {
                return (config.debug === true) ?
                    $http.get(config.baseUrl + '/tasks.find.json') :
                    $http.get(config.baseUrl + '/tarefas');
            };

            var _put = function(id, data){
                return (config.debug === true) ?
                    $http.get(config.baseUrl + '/tasks.update.json') :
                    $http.put(config.baseUrl + '/tarefas/' + id, data);
            };

            var _add = function(data){
                return (config.debug === true) ?
                    $http.get(config.baseUrl + '/tasks.save.json') :
                    $http.post(config.baseUrl + '/tarefas', data);
            };

            var _delete = function(id) {
                return (config.debug === true) ?
                    $http.get(config.baseUrl + '/tasks.delete.json') :
                    $http.delete(config.baseUrl + '/tarefas/' + id);
            };

            return {
                get: _get,
                put: _put,
                add: _add,
                delete: _delete
            };
        }]);

})();
