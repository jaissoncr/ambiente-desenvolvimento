(function(){
    'use strict';

    angular.module('app.perguntas')

        .controller('PerguntasCtrl', [
            '$scope', 'perguntas', 'perguntasAPI', 'etiquetasAPI', 'logger',
            function($scope, perguntas, perguntasAPI, etiquetasAPI, logger){
                $scope.perguntas = perguntas.data;
                $scope.buttonSendAnswer = 'Enviar';
                $scope.buttonDeleteAnswer = 'Deletar';
                $scope.answer = '';
                $scope.sendingAnswer = false;
                $scope.remainingCount = 0;
            

                // Etiquetas
                etiquetasAPI.get().success(function(data) {
                    $scope.etiquetas = data;
                });
                
                // Get Etiqueta
                $scope.get = function(etiqueta){
                    etiquetasAPI.get().success(function(data) {
                    //$scope.pergunta.answer.text = etiqueta.descricao;
                    console.log(etiqueta.descricao);
                    });
                    
                };
                

                // Send Answer
                $scope.send = function(pergunta){
                    var index;

                    $scope.sendingAnswer = true;
                    perguntasAPI.sendAnswer(pergunta.answer.text).success(function(){
                        index = $scope.perguntas.indexOf(pergunta);
                        $scope.perguntas.splice(index, 1);
                        logger.logSuccess('Pergunta respondida com sucesso!');
                    });
                };

                // Delete Answer
                $scope.remove = function(pergunta){
                    var index;
                    perguntasAPI.delete(pergunta.id).success(function(data) {
                      if (data.result === 1) {
                          index = $scope.perguntas.indexOf(pergunta);
                          $scope.perguntas.splice(index, 1);
                          logger.log('Pergunta removida com sucesso!');
                      } else {
                          logger.logError('Erro ao deletar a pergunta! Tente novamente.');
                      }
                    });
                };
            }
        ])


        .controller('AssinaturasCtrl', [
            '$scope', 'assinaturas', 'perguntasAPI', 'logger',
                function($scope, assinaturas, perguntasAPI, logger){
                $scope.assinaturas = assinaturas.data;
                $scope.buttonSaveAssinaturas = 'Salvar Assinaturas';
    
                // Add Assinatura
                $scope.add = function(assinatura){
                var index;
                    perguntasAPI.addAssinatura(assinatura.id).success(function(data){
                        $scope.assinaturas.push(assinatura);
                        $scope.assinaturas.splice(index, 1);
                        logger.logSuccess('Assinaturas adicionadas');
                    });
                };
    
                // Remove Saudação
                $scope.removeSaudacao = function(assinatura){
                    perguntasAPI.deleteAssinatura(assinatura).success(function(){
                            delete assinatura.saudacao;
                            logger.log('Saudação removida!');
                    });
                };
    
                // Remove Despedida
                $scope.removeDespedida = function(assinatura){
                    perguntasAPI.deleteAssinatura(assinatura).success(function(){
                             delete assinatura.despedida;
                             logger.log('Assinatura de despedida removida!');
                    });
                };
            }
        ]);
})();
