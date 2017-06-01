(function () {
    'use strict';

    function uiEmail(){
        return {
            templateUrl: 'views/email-button.html',
            restrict: 'E',
            replace: true,
            link: function(scope, elm) {
                elm.bind('click', function(){
                    if (!scope.savingEmail){
                        scope.setSavingEmail(true);
                        var message = '';
                        var success = false;
                        scope.changeStatus(scope.email).success( function(data) {
                            if (data.result) {
                                message = data.message;
                                success = true;
                                scope.email.pivot.status = data.status;
                            } else {
                                if (!data.message) {
                                    message = 'Ocorreu um erro na requisição, favor tentar novamente mais tarde.';
                                } else {
                                    message = data.message;
                                }
                                scope.email.pivot.status = data.status;
                            }
                        })['finally']( function(){
                            scope.setSavingEmail(false);
                            if (scope.email.pivot.status === 1){
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

    angular.module('app.emails')
        .directive('uiEmail', uiEmail)
        ;
})();
