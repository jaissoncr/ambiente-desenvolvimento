(function(){
    'use strict';

    angular.module('app.qualificacoes')
        .controller('QualificacoesCtrl', [
            '$scope', 'qualificacoes', 'qualificacoesAPI', 'logger',
            function($scope, qualificacoes, qualificacoesAPI, logger){
              $scope.qualificacoes = qualificacoes.data;
              $scope.buttonNovaRegra = 'Adicionar Nova Regra';
              $scope.ratingTime = 'Em até 24 horas';
              console.log($scope.qualificacoes.rating);
              
            
              
              
              // Status Pagamento
              $scope.isPaid = 'Pagamento Recebido';
            //   for (var i = 0, l = $scope.qualificacoes.length; i < l; i++) {
            //      $scope.qualificacoes.tags = $scope.qualificacoes[i].tags;
            //      console.log($scope.qualificacoes.tags);    
            //   }
            
            //   $scope.tagIsPaid = $scope.qualificacao.status(function (isPaid){
            //       if (isPaid === 'paid'){
            //           $scope.isPaid = 'Pagamento Recebido';
            //       } if (isPaid === 'cancelled'){
            //           $scope.isPaid = 'Pagamento Cancelado/Devolvido';
            //       }
            //      console.log($scope.isPaid);
            //   });
              
              // Status Entrega
              $scope.isDelivered = 'Produto Entregue';
              $scope.statusEntrega = 'Entregue';
            //   $scope.tagIsDelivered = $scope.qualificacoes.tags.filter(function (isDelivered){
            //       if (isDelivered === 'delivered'){
            //           $scope.isDelivered = 'Produto Entregue';
            //           $scope.statusEntrega = 'Entregue';
            //       } if (isDelivered === 'not_delivered'){
            //           $scope.isDelivered = 'Em Trânsito';
            //           $scope.statusEntrega = 'Em trânsito';
            //       } 
            //   });
              
              // Qualificação
              //$scope.qualificou = 'Qualificou Positivo';
              //$scope.recomendacao = 'Sim';
                //   if ($scope.qualificacao.rating === 'positive'){
                //       $scope.recomendacao = 'Sim';
                //       $scope.feedback.qualificacao = 'Qualificou Positivo';
                //   }
                      
                //   if ($scope.qualificacao.feedback.sale.rating === 'neutral'){
                //       $scope.recomendacao = 'Não tenho certeza';
                //       $scope.feedback.sale.qualificacao = 'Qualificou Neutro';
                //   } 
                //   if ($scope.qualificacao.feedback.sale.rating === 'negative'){
                //       $scope.recomendacao = 'Não';
                //       $scope.feedback.sale.qualificacao = 'Qualificou Negativo';
                //   }
                  
            
              // Delete Qualificação
              $scope.remove = function(qualificacao){
                var index;
                    qualificacoesAPI.delete(qualificacao.id).success(function(data) {
                    if (data.result === 1) {
                        index = $scope.qualificacoes.indexOf(qualificacao);
                        $scope.qualificacoes.splice(index, 1);
                        logger.log('Qualificação automática removida!');
                    } else {
                        logger.logError('Erro ao deletar a qualificação! Tente novamente.');
                    }
                });
                };    
                
               // Disable/Enable Qualificação

               $scope.changeStatus = function(qualificacao){
                    if (qualificacao.pivot.status === 1){
                        return qualificacoesAPI.disable(qualificacao.id);
                    }
    
                    return qualificacoesAPI.enable(qualificacao.id);
               };
    
               $scope.setSavingQualificacao = function(status){
                    $scope.savingQualificacao = status;
               };
    
               $scope.logSuccess = function(message){
                    logger.logSuccess(message);
               };
    
               $scope.logError = function(message){
                    logger.logError(message);
               };
                
            }
        ]);
})();
