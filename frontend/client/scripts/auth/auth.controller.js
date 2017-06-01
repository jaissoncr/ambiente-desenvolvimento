(function(){
    'use strict';

    angular.module('app.auth')
        .factory('authAPI', [
            '$http', 'config',
            function($http, config){
                var _getAuth = function() {
                    return (config.debug) ?
                        $http.get(config.baseUrl + '/auth.json') :
                        $http.get(config.baseUrl + '/auth');
                };

                return { getAuth: _getAuth };
            }
        ]);
})();
