(function () {
    'use strict';

    function taskCtrl($scope, tasksAPI, filterFilter, $rootScope, logger) {
        $scope.tasks = [];
        $scope.remainingCount = 0;

        tasksAPI.get().success(function(data){
            $scope.tasks = data;
            $scope.remainingCount = filterFilter($scope.tasks, {completed: false}).length;
        });

        $scope.newTask = '';
        $scope.newTaskSending = false;

        $scope.oldTask = null;
        $scope.editedTask = null;

        $scope.statusFilter = {
            completed: false
        };

        $scope.filter = function(filter) {
            switch (filter) {
                case 'all':
                    $scope.statusFilter = '';
                    return;
                case 'active':
                    $scope.statusFilter = {
                        completed: false
                    };
                    return;
                case 'completed':
                    $scope.statusFilter = {
                        completed: true
                    };
                    return;
            }
        };

        $scope.add = function() {
            var newTask;
            newTask = $scope.newTask.trim();
            if (newTask.length === 0) {
                return;
            }
            $scope.newTaskSending = true;
            tasksAPI.add({title: newTask}).success(function(data){
                $scope.newTaskSending = false;
                if (data) {
                    $scope.tasks.push({
                        id: data.id,
                        title: data.title,
                        completed: data.completed
                    });
                    $scope.newTask = '';
                    $scope.remainingCount++;

                    logger.logSuccess('Nova Tarefa: "' + data.title + '" adicionada');
                } else {
                    logger.logError('Erro ao adicionar tarefa');
                }
            });
        };

        $scope.edit = function(task) {
            $scope.oldTask = angular.copy(task);
            $scope.editedTask = task;
        };

        $scope.doneEditing = function(task) {
            if ($scope.editedTask === null) {
                return false;
            }
            $scope.editedTask = null;
            if (!task.title.trim()) {
                task.title = $scope.oldTask.title;
                $scope.oldTask = null;
                logger.logError('Você deve informar uma descrição válida');
            } else {
                task.title = task.title.trim();
                tasksAPI.put(task.id, task).success(function(data){
                    if (data.result === 1) {
                        task.title = task.title;
                        task.completed = task.completed;
                        logger.logSuccess('Tarefa atualizada com sucesso');
                    } else {
                        logger.logError('Erro ao alterar tarefa.');
                    }
                });
            }
        };

        $scope.triggerSubmit = function(event){
            event.stopPropagation();
            setTimeout(function(){
                angular.element(event.target.parentElement).triggerHandler('submit');
            }, 0);
        };

        $scope.remove = function(task) {
            var index;
            // Remove task
            tasksAPI.delete(task.id).success(function(data) {
                if (data.result === 1) {
                    $scope.remainingCount -= task.completed ? 0 : 1;
                    index = $scope.tasks.indexOf(task);
                    $scope.tasks.splice(index, 1);
                    logger.log('Tarefa removida.');
                } else {
                    logger.logError('Ocorreu um erro ao remover a tarefa..');
                }
            });
        };

        $scope.completed = function(task) {
            tasksAPI.put(task.id, task).success(function(data){
                if (data.result === 1) {
                    $scope.remainingCount += task.completed ? -1 : 1;
                    if (task.completed) {
                        if ($scope.remainingCount > 0) {
                            if ($scope.remainingCount === 1) {
                                logger.log('Quase lá.. Falta apenas ' + $scope.remainingCount + ' tarefa');
                            } else {
                                logger.log('Bom trabalho! Restam ' + $scope.remainingCount + ' tarefas');
                            }
                        } else {
                            logger.logSuccess('Parabéns! Todas as tarefas foram concluídas :)');
                        }
                    }
                } else {
                    logger.logError('Ocorreu um erro ao concluir a tarefa.');
                }
            });
        };

        $scope.clearCompleted = function() {
            var tasks = $scope.tasks.filter(function(val) {
                return val.completed === true;
            });
            if (tasks.length > 0) {
                tasksAPI.delete('completed').success(function(data) {
                    if (data.result === 1) {
                        var index;
                        tasks.forEach(function(task) {
                            $scope.tasks.filter(function(val) {
                                if (task.id === val.id) {
                                    $scope.remainingCount -= val.completed ? 0 : 1;
                                    index = $scope.tasks.indexOf(val);
                                    $scope.tasks.splice(index, 1);
                                }
                            });
                        });
                        logger.log('Tarefas removidas');
                    } else {
                        logger.logError('Ocorreu um erro ao remover as tarefas concluídas.');
                    }
                });
            }
        };

        $scope.markAll = function(completed) {
            $scope.tasks.forEach(function(task) {
                task.completed = completed;
            });
            tasksAPI.put('completed', $scope.tasks).success(function(data){
                if (data.result === 1) {
                    $scope.remainingCount = completed ? 0 : $scope.tasks.length;
                    if (completed) {
                        logger.logSuccess('Parabéns! Todas as tarefas foram concluídas :)');
                    }
                } else {
                    logger.logError('Ocorreu um problema ao concluir as tarefas, tente novamente mais tarde.');
                }
            });
        };

        $scope.$watch('remainingCount == 0', function(val) {
            if (val) {
                $scope.allChecked = !val;
            }
        });

        $scope.$watch('remainingCount', function(newVal, oldVal) {
            if (newVal !== oldVal) {
                $rootScope.$broadcast('taskRemaining:changed', newVal);
            }
        });

    }

    angular.module('app.task')
        .controller('taskCtrl', [ '$scope', 'tasksAPI', 'filterFilter', '$rootScope', 'logger', taskCtrl]);
})();
