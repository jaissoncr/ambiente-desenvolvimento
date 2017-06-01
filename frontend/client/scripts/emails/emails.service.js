(function () {
    'use strict';

    function emailsAPI($http, config){
        var _get = function(){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/emails.index.json') :
                $http.get(config.baseUrl + '/emails');
        };
        
        var _delete = function(id) {
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/emails.index.json', {id: id}) :
                $http.delete(config.baseUrl + '/emails/' + id);
        };

        return {
            get: _get,
            delete: _delete
        };
    }

    angular.module('app.emails')
        .factory('emailsAPI', [ '$http', 'config', emailsAPI ])
    ;
})();
