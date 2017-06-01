(function () {
    'use strict';

    function uiQualificacao(){
        return {
            templateUrl: 'views/qualificacao-button.html',
            restrict: 'E',
            replace: true,
            link: function(scope, elm) {
                elm.bind('click', function(){
                    if (!scope.savingQualificacao){
                        scope.setSavingQualificacao(true);
                        var message = '';
                        var success = false;
                        scope.changeStatus(scope.qualificacao).success( function(data) {
                            if (data.result) {
                                message = data.message;
                                success = true;
                                scope.qualificacao.pivot.status = data.status;
                            } else {
                                if (!data.message) {
                                    message = 'Ocorreu um erro na requisição, favor tentar novamente mais tarde.';
                                } else {
                                    message = data.message;
                                }
                                scope.qualificacao.pivot.status = data.status;
                            }
                        })['finally']( function(){
                            scope.setSavingQualificacao(false);
                            if (scope.qualificacao.pivot.status === 1){
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

    angular.module('app.qualificacoes')
        .directive('uiQualificacao', uiQualificacao)
        ;
})();
