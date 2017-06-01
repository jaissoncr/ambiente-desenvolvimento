(function () {
    'use strict';

    function uiBlockUser(){
        return {
            templateUrl: 'views/block-user-button.html',
            restrict: 'E',
            replace: true,
            link: function(scope, elm) {
                elm.bind('click', function(){
                    if (!scope.savingUser){
                        scope.setSavingUser(true);
                        var message = '';
                        var success = false;
                        scope.changeStatus(scope.usuario).success( function(data) {
                            if (data.result) {
                                message = data.message;
                                success = true;
                                scope.usuario.pivot.status = data.status;
                            } else {
                                if (!data.message) {
                                    message = 'Ocorreu um erro na requisição, favor tentar novamente mais tarde.';
                                } else {
                                    message = data.message;
                                }
                                scope.usuario.pivot.status = data.status;
                            }
                        })['finally']( function(){
                            scope.setSavingUser(false);
                            if (scope.usuario.pivot.status === 1){
                                elm.find(':checkbox')[0].checked = false;
                            } else {
                                elm.find(':checkbox')[0].checked = true;
                            }

                            if (!success) {
                                scope.logError(message);
                            } else {
                                scope.logSuccess(message);
                            }
                        });
                    }
                });
            }
        };
    }

    angular.module('app.usuarios')
        .directive('uiBlockUser', uiBlockUser)
        ;
})();
