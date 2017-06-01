(function () {
    'use strict';

    function AppCtrl($scope, $rootScope, $route, $document, authAPI) {

        var date = new Date();
        var year = date.getFullYear();

        $scope.main = {
            brand: 'MLTools',
            name: '',
            year: year
        };

        $scope.pageTransitionOpts = [
            {
                name: 'Fade up',
                'class': 'animate-fade-up'
            }, {
                name: 'Scale up',
                'class': 'ainmate-scale-up'
            }, {
                name: 'Slide in from right',
                'class': 'ainmate-slide-in-right'
            }, {
                name: 'Flip Y',
                'class': 'animate-flip-y'
            }
        ];

        $scope.admin = {
            layout: 'wide',                                 // 'boxed', 'wide'
            menu: 'vertical',                               // 'horizontal', 'vertical', 'collapsed'
            fixedHeader: true,                              // true, false
            fixedSidebar: true,                             // true, false
            pageTransition: $scope.pageTransitionOpts[0]    // unlimited, add your own
        };

        $scope.$watch('admin', function(newVal, oldVal) {
            if (newVal.menu === 'horizontal' && oldVal.menu === 'vertical') {
                $rootScope.$broadcast('nav:reset');
            }
            if (newVal.fixedHeader === false && newVal.fixedSidebar === true) {
                if (oldVal.fixedHeader === false && oldVal.fixedSidebar === false) {
                    $scope.admin.fixedHeader = true;
                    $scope.admin.fixedSidebar = true;
                }
                if (oldVal.fixedHeader === true && oldVal.fixedSidebar === true) {
                    $scope.admin.fixedHeader = false;
                    $scope.admin.fixedSidebar = false;
                }
            }
            if (newVal.fixedSidebar === true) {
                $scope.admin.fixedHeader = true;
            }
            if (newVal.fixedHeader === false) {
                $scope.admin.fixedSidebar = false;
            }
        }, true);

        $scope.color = {
            primary:        '#1BB7A0',
            success:        '#94B758',
            info:           '#56BDF1',
            infoAlt:        '#7F6EC7',
            warning:        '#F3C536',
            danger:         '#FA7B58',
            gray:           '#DCDCDC'
        };

        $rootScope.$on('$routeChangeSuccess', function() {
            $document.scrollTo(0, 0);
        });

        $scope.getAuthUser = function() {
            authAPI.getAuth().success(function(data){
                $scope.user = data;
            });
        };
    }

    function NavCtrl($scope, tasksAPI, filterFilter) {
        var tasks = tasksAPI.get();
        $scope.tasks = [];
        $scope.taskRemainingCount = 0;

        tasks.success(function(data){
            $scope.tasks = data;
            $scope.taskRemainingCount = filterFilter(data, {completed: false}).length;
        }).error(function(){
            return [];
        });

        $scope.$on('taskRemaining:changed', function(event, count) {
            $scope.taskRemainingCount = count;
        });
    }

    function DashboardCtrl($scope, usuarios) {
        var desbloqueados = 0;
        var bloqueados = 0;

        usuarios.data.forEach( function(item){
            if(item.pivot.status === 0){
                bloqueados++;
            } else {
                desbloqueados++;
            }
        });

        $scope.usuariosBloqueadosChart = {};
        $scope.usuariosBloqueadosChart.data = [
            {label: 'Desbloqueados',data: desbloqueados},
            {label: 'Bloqueados',data: bloqueados}
        ];
        $scope.usuariosBloqueadosChart.options = {
            series: {
                pie: {
                    show: true,
                    innerRadius: 0.45
                },
                legend: {
                    show: false
                },
                grid: {
                    hoverable: true,
                    clickable: true
                },
                colors: ['#1BB7A0', '#FA7B58'],
                tooltip: true,
                tooltipOpts: {
                    content: '%p.0%, %s',
                    defaultTheme: true
                }
            }
        };
        
        var simpleColor, simpleData;



        

        // line & area
        simpleData = [
            {day: '08/09', value: 20},
            {day: '09/09', value: 10},
            {day: '10/09', value: 5},
            {day: '11/09', value: 5},
            {day: '12/09', value: 20},
            {day: '13/09', value: 19},
            {day: '14/09', value: 19}
        ];

        simpleColor = [$scope.color.success];

        $scope.simple1 = {
            data: simpleData,
            type: "line",
            options: {
                xkey: "day",
                ykeys: ["value"],
                labels: ["R$"],
                lineWidth: "2",
                lineColors: simpleColor
            }
        };

        $scope.simple2 = {
            data: simpleData,
            type: "area",
            options: {
                xkey: "day",
                ykeys: ["value"],
                labels: ["R$"],
                lineWidth: "2",
                lineColors: simpleColor
            }
        };



       

        
        
        
    }

    angular.module('app')
        .controller('AppCtrl', [ '$scope', '$rootScope', '$route', '$document', 'authAPI', AppCtrl ])
        .controller('NavCtrl', [ '$scope', 'tasksAPI', 'filterFilter', NavCtrl ])
        .controller('DashboardCtrl', [ '$scope', 'usuarios', DashboardCtrl ])
        ;

})();
