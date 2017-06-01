(function () {
    'use strict';

    angular.module('app', [
        // Angular modules
        'ngRoute',
        'ngAnimate',
        'ngAria',

        // 3rd Party Modules
        'ui.bootstrap',
        'easypiechart',
        'ui.tree',
        // 'ngMap',
        'ngTagsInput',
        'textAngular',
        'angular-loading-bar',
        'duScroll',

        // Custom modules
        'app.nav',
        'app.i18n',
        'app.chart',
        'app.ui',
        'app.ui.form',
        'app.ui.form.validation',
        // 'app.ui.map',
        // 'app.page',
        'app.table',
        'app.task',
        'app.usuarios',
        'app.auth',
        'app.anuncios',
        'app.produtos',
        'app.perguntas',
        'app.etiquetas',
        'app.emails',
        'app.qualificacoes',
        'app.vendas',
        'app.clientes',
    ])

    .value('config', {
        // Local PHP
        // baseUrl: 'https://app.dev'
        // Produção
        // baseUrl: 'http://mltools.com.br'
        // Local
        // baseUrl: 'http://localhost:9009/tests',
        baseUrl: 'https://mltools-client-jaissoncr.c9users.io/client/tests',
        debug: true
    })

    ;

})();
