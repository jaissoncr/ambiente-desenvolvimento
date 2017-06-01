(function () {
    'use strict';

    // cusor focus when dblclick to edit
    function taskFocus($timeout) {
        function link (scope, ele, attrs) {
            scope.$watch(attrs.taskFocus, function(newVal) {
                if (newVal) {
                    $timeout(function() {
                        return ele[0].focus();
                    }, 0, false);
                }
            });
        }

        var directive = {
            link: link
        };

        return directive;
    }

    angular.module('app.task')
        .directive('taskFocus', ['$timeout', taskFocus]);

})();
