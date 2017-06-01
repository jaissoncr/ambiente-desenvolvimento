(function(){
    'use strict';

    angular.module('app.etiquetas')

        .controller('EtiquetasCtrl', [
            '$scope', 'etiquetas', 'etiquetasAPI', 'logger',
            function($scope, etiquetas, etiquetasAPI, logger){
            $scope.etiquetas = etiquetas.data;
            $scope.panelColor = "panel panel-primary";
            $scope.panelIcon = "glyphicon glyphicon-plus";
            $scope.panelTag = 'Adicionar Etiqueta';
            $scope.buttonSaveTag = 'Salvar';

            $scope.limpar = function() {
                $scope.etiqueta = undefined;
            }
            

            // Add Etiqueta
            $scope.save = function(etiqueta){
                etiquetasAPI.add(etiqueta).success(function(data){
                    if (etiqueta.id === undefined)
                        logger.logSuccess('Etiqueta adicionada com sucesso');
                    else
                        logger.logSuccess('Etiqueta atualizada com sucesso');
                    etiqueta.id = $scope.etiquetas.length + 1;
                    $scope.etiquetas.push(etiqueta);
                    delete $scope.etiqueta;
                    $scope.panelColor = "panel panel-primary";
                    $scope.panelIcon = "glyphicon glyphicon-plus";
                    $scope.panelTag = 'Adicionar Etiqueta';
                });
            };

            // Edit Etiqueta
            $scope.edit = function(etiqueta){
                $scope.panelTag = 'Editar Etiqueta';
                $scope.selectedTag = etiqueta.nome;
                $scope.etiqueta = etiqueta;
                $scope.panelColor = "panel panel-warning";
                $scope.panelIcon = "glyphicon glyphicon-edit";
            };

            // Remove Etiqueta
            $scope.remove = function(etiqueta){
            var index;
                etiquetasAPI.delete(etiqueta).success(function(data) {
                    index = $scope.etiquetas.indexOf(etiqueta);
                    $scope.etiquetas.splice(index, 1);
                    logger.log('Etiqueta removida!');
            });
            };
        }
        ])

})();
