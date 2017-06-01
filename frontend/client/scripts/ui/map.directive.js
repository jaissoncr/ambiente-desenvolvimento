(function () {
    'use strict';

    angular.module('app.ui.map')
        .directive('uiJqvmap', uiJqvmap);

    function uiJqvmap() {
        return {
            restrict: 'A',
            scope: {
                options: '='
            },
            link: function(scope, ele, attrs) {
                var options;

                options = scope.options;
                ele.vectorMap(options);
            }
        }
    }

})(); 