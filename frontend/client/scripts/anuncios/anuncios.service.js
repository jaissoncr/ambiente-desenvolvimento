(function () {
    'use strict';

    function anunciosAPI($http, config){
        var _get = function(){
            return (config.debug === true) ?
                $http.get(config.baseUrl + '/anuncios.index.json') :
                $http.get(config.baseUrl + '/anuncios');
        };

        return {
            get: _get
        };
    }

    angular.module('app.anuncios')
        .factory('anunciosAPI', [ '$http', 'config', anunciosAPI ])
    ;
})();
