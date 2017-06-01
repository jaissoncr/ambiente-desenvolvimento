(function () {
    'use strict';

    angular.module('app')
        .config(['$routeProvider', function($routeProvider) {
            $routeProvider
                .when('/', { redirectTo: '/dashboard'} )

                .when('/dashboard', {
                    templateUrl: 'views/dashboard.html',
                    controller: 'DashboardCtrl',
                    resolve: {
                        usuarios: [
                            'usuariosAPI',
                            function(usuariosAPI) {
                                return usuariosAPI.getUsuarios();
                            }
                        ]
                    }
                })
                
                .when('/clientes', {
                    templateUrl: 'views/clientes/list.html',
                    controller: 'ClientesCtrl',
                    resolve: {
                        clientes: [
                            'clientesAPI',
                            function(clientesAPI) {
                                return clientesAPI.get();
                            }
                        ]
                    }
                })
                
                .when('/adicionar-cliente', {
                    templateUrl: 'views/clientes/adicionar-cliente.html',
                    controller: 'ClientesCtrl',
                    resolve: {
                        clientes: [
                            'clientesAPI',
                            function(clientesAPI) {
                                return clientesAPI.get();
                            }
                        ]
                    }
                })
                
                .when('/editar-cliente', {
                    templateUrl: 'views/clientes/editar-cliente.html',
                    controller: 'ClientesCtrl',
                    resolve: {
                        clientes: [
                            'clientesAPI',
                            function(clientesAPI) {
                                return clientesAPI.get();
                            }
                        ]
                    }
                })
                
                    
                .when('/produtos', {
                    templateUrl: 'views/produtos/list.html',
                    controller: 'ProdutosCtrl',
                    resolve: {
                        produtos: [
                            'produtosAPI',
                            function(produtosAPI) {
                                return produtosAPI.get();
                            }
                        ]
                    }
                })
                
                .when('/adicionar-produto', {
                    templateUrl: 'views/produtos/adicionar-produto.html',
                    controller: 'ProdutosCtrl',
                    resolve: {
                        produtos: [
                            'produtosAPI',
                            function(produtosAPI) {
                                return produtosAPI.get();
                            }
                        ]
                    }
                })
                
                .when('/editar-produto', {
                    templateUrl: 'views/produtos/editar-produto.html',
                    controller: 'ProdutosCtrl',
                    resolve: {
                        produtos: [
                            'produtosAPI',
                            function(produtosAPI) {
                                return produtosAPI.get();
                            }
                        ]
                    }
                })
                

                //.when('/movimentacoes-estoque', { templateUrl: 'views/movimentacoes-estoque/movimentacoes-estoque.html' } )
                //.when('/movimentacoes-estoque/adicionar', { templateUrl: 'views/movimentacoes-estoque/adicionar.html' } )

                //.when('/clientes', { templateUrl: 'views/clientes/clientes.html' } )
                //.when('/clientes/adicionar', { templateUrl: 'views/clientes/adicionar.html' } )

                .when('/perguntas', {
                    templateUrl: 'views/perguntas/list.html',
                    controller: 'PerguntasCtrl',
                    resolve: {
                        perguntas: [
                            'perguntasAPI',
                            function(perguntasAPI) {
                                return perguntasAPI.get();
                            }
                        ]
                    }
                })
                
                
                .when('/etiquetas', {
                    templateUrl: 'views/perguntas/etiquetas.html',
                    controller: 'EtiquetasCtrl',
                    resolve: {
                        etiquetas: [
                            'etiquetasAPI',
                            function(etiquetasAPI) {
                                return etiquetasAPI.get();
                            }
                        ]
                    }
                })
                
                .when('/assinaturas', {
                    templateUrl: 'views/perguntas/assinaturas.html',
                    controller: 'AssinaturasCtrl',
                    resolve: {
                        assinaturas: [
                            'perguntasAPI',
                            function(perguntasAPI) {
                                return perguntasAPI.getAssinaturas();
                            }
                        ]
                    }
                })
                
                .when('/bloqueio-usuarios', {
                    templateUrl: 'views/bloqueio-usuarios/list.html',
                    controller: 'BloqueioUsuariosCtrl',
                    resolve: {
                        usuarios : [
                            'usuariosAPI',
                            function(usuariosAPI) {
                                return usuariosAPI.getUsuarios();
                            }
                        ]
                    }
                } )
                
                .when('/vendas', {
                    templateUrl: 'views/vendas/list.html',
                    controller: 'VendasCtrl',
                    resolve: {
                        vendas: [
                            'vendasAPI',
                            function(vendasAPI) {
                                return vendasAPI.get();
                            }
                        ]
                    }
                })
                
                .when('/adicionar-venda', {
                    templateUrl: 'views/vendas/adicionar-venda.html',
                    controller: 'VendasCtrl',
                    resolve: {
                        vendas: [
                            'vendasAPI',
                            function(vendasAPI) {
                                return vendasAPI.get();
                            }
                        ]
                    }
                })
                
                .when('/editar-venda', {
                    templateUrl: 'views/vendas/editar-venda.html',
                    controller: 'VendasCtrl',
                    resolve: {
                        vendas: [
                            'vendasAPI',
                            function(vendasAPI) {
                                return vendasAPI.get();
                            }
                        ]
                    }
                })

                
                //.when('/vendas/notas-fiscais', { templateUrl: 'views/vendas/notas-fiscais.html' } )
                //.when('/vendas/editar-nota-fiscal', { templateUrl: 'views/vendas/editar-nota-fiscal.html' } )

                //.when('/emails', { templateUrl: 'views/emails/emails.html' } )
                //.when('/emails/configurar', { templateUrl: 'views/emails/configurar.html' } )
                
                .when('/emails', {
                    templateUrl: 'views/emails/list.html',
                    controller: 'EmailsCtrl',
                    resolve: {
                        emails: [
                            'emailsAPI',
                            function(emailsAPI) {
                                return emailsAPI.get();
                            }
                        ]
                    }
                })
                
                .when('/adicionar-email', {
                    templateUrl: 'views/emails/adicionar-email.html',
                    controller: 'EmailsCtrl',
                    resolve: {
                        emails: [
                            'emailsAPI',
                            function(emailsAPI) {
                                return emailsAPI.get();
                            }
                        ]
                    }
                })
                
                .when('/qualificacoes', {
                    templateUrl: 'views/qualificacoes/list.html',
                    controller: 'QualificacoesCtrl',
                    resolve: {
                        qualificacoes: [
                            'qualificacoesAPI',
                            function(qualificacoesAPI) {
                                return qualificacoesAPI.get();
                            }
                        ]
                    }
                })
                
                .when('/adicionar-qualificacao', {
                    templateUrl: 'views/qualificacoes/adicionar-qualificacao.html',
                    controller: 'QualificacoesCtrl',
                    resolve: {
                        qualificacoes: [
                            'qualificacoesAPI',
                            function(qualificacoesAPI) {
                                return qualificacoesAPI.get();
                            }
                        ]
                    }
                })
                
                .when('/configuracoes', {
                    templateUrl: 'views/configuracoes/list.html',
                })

                //.when('/configuracoes/dados', { templateUrl: 'views/configuracoes/dados.html' } )
                //.when('/configuracoes/certificado', { templateUrl: 'views/configuracoes/certificado.html' } )

                .when('/tarefas', {
                    templateUrl: 'views/tasks/tasks.html',
                    controller: 'taskCtrl',
                    resolve: {
                        tasks: [
                            'tasksAPI',
                            function(tasksAPI) {
                                return tasksAPI.get();
                            }
                        ]
                    }
                } )

                .when('/anuncios', {
                    templateUrl: 'views/anuncios/list.html',
                    controller: 'anunciosCtrl',
                    resolve: {
                        anuncios: [
                            'anunciosAPI',
                            function(anunciosAPI) {
                                return anunciosAPI.get();
                            }
                        ]
                    }
                } )

                .when('/404', { templateUrl: 'views/erros/404.html' } )
                .when('/500', { templateUrl: 'views/erros/500.html' } )

                .otherwise({ redirectTo: '/404' });

        }]
    );

})();
