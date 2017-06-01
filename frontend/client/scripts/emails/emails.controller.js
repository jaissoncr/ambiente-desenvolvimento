(function(){
    'use strict';

    angular.module('app.emails')
        .controller('EmailsCtrl', [
            '$scope', 'emails', 'emailsAPI', 'logger',
            function($scope, emails, emailsAPI, logger){
            $scope.emails = emails.data;   
            $scope.isPaid = 'Pagamento Recebido';
            $scope.isDelivered = 'Entregue';
                
            // Remove E-mail
            $scope.remove = function (email){
            var index;
                emailsAPI.delete(email).success(function(data) {
                   index = $scope.emails.indexOf(email);
                   $scope.emails.splice(index, 1);
                   logger.log('Regra de e-mail removida!');
                });
            };    
                
            }
        ]);
})();
