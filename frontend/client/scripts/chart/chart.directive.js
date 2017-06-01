(function () {
    'use strict';

    angular.module('app.chart')
        .directive('gaugeChart', gaugeChart)
        .directive('morrisChart', morrisChart)
        .directive('flotChart', flotChart)
        .directive('flotChartRealtime', flotChartRealtime)
        .directive('sparkline', sparkline);


    function gaugeChart() {
        var directive = {
            restrict: 'A',
            scope: {
                data: '=',
                options: '='
            },
            link: link
        };

        return directive;

        function link(scope, ele, attrs) {
            var data, options, gauge;
            data = scope.data;
            options = scope.options;
            
            gauge = new Gauge(ele[0]).setOptions(options);
            gauge.maxValue = data.maxValue;
            gauge.animationSpeed = data.animationSpeed;
            gauge.set(data.val);
        }        
    }

    function morrisChart() {
        var directive = {
            restrict: 'A',
            scope: {
                data: '=',
                type: '=',
                options: '='
            },
            link: link
        };

        return directive;

        function link(scope, ele, attrs) {
            var data, type, options, func;
            data = scope.data;
            type = scope.type;

            switch (type) {
                case 'line':
                    options = angular.extend({
                        element: ele[0],
                        data: data
                    }, scope.options);
                    new Morris.Line(options);
                    break;
                case 'area':
                    options = angular.extend({
                        element: ele[0],
                        data: data
                    }, scope.options);
                    new Morris.Area(options);
                    break;
                case 'bar':
                    options = angular.extend({
                        element: ele[0],
                        data: data
                    }, scope.options);
                    new Morris.Bar(options);
                    break;
                case 'donut':
                    options = angular.extend({
                        element: ele[0],
                        data: data
                    }, scope.options);
                    if (options.formatter) {
                        func = new Function('y', 'data', options.formatter);
                        options.formatter = func;
                    }
                    new Morris.Donut(options);
            }

        }        
    }

    function flotChart() {
        var directive = {
            restrict: 'A',
            scope: {
                data: '=',
                options: '='
            },
            link: link
        };

        return directive;

        function link(scope, ele, attrs) {
            var data, options, plot;
            data = scope.data;
            options = scope.options;
            
            // console.log data
            // console.log options

            plot = $.plot(ele[0], data, options);            
        }        
    }

    function flotChartRealtime() {
        var directive = {
            restrict: 'A',
            link: link
        };

        return directive;

        function link(scope, ele, attrs) {
            var data1, data2, getRandomData1, getRandomData2, makeGetRandomData;
            var data, getRandomData, plot, totalPoints, update, updateInterval;

            data1 = [];
            data2 = [];
            totalPoints = 200;
            updateInterval = 200;


            makeGetRandomData = function(data, min, max) {

                function getRandomData() {
                    var i, prev, res, y;
                    if (data.length > 0) {
                        data = data.slice(1);
                    }
                    while (data.length < totalPoints) {
                        prev = (data.length > 0 ? data[data.length - 1] : (min + max)/2);
                        y = prev + Math.random() * 4 - 2;
                        if (y < min) {
                            y = min;
                        } else {
                            if (y > max) {
                                y = max;
                            }
                        }
                        data.push(y);
                    }
                    res = [];
                    i = 0;
                    while (i < data.length) {
                        res.push([i, data[i]]);
                        ++i;
                    }
                    return res;
                }
                return getRandomData;    
            }

            getRandomData1 = makeGetRandomData(data1, 28, 42);
            getRandomData2 = makeGetRandomData(data2, 56, 72);


            update = function() {
                plot.setData([getRandomData1(), getRandomData2()]);
                plot.draw();
                setTimeout(update, updateInterval);
            };


            plot = $.plot(ele[0], [getRandomData1(), getRandomData2()], {
                series: {
                    lines: {
                        show: true,
                        fill: true
                    },
                    shadowSize: 0
                },
                yaxis: {
                    min: 0,
                    max: 100
                },
                xaxis: {
                    show: false
                },
                grid: {
                    hoverable: true,
                    borderWidth: 1,
                    borderColor: '#eeeeee'
                },
                colors: ["#40DEC8", "#CDFFFE"]
            });

            update();
         
        }        
    }

    function sparkline() {
        var directive = {
            restrict: 'A',
            scope: {
                data: '=',
                options: '='
            },
            link: link
        };

        return directive;

        function link(scope, ele, attrs) {
            var data, options, sparkResize, sparklineDraw;

            data = scope.data;

            options = scope.options;

            sparkResize = void 0;

            sparklineDraw = function() {
                ele.sparkline(data, options);
            };

            $(window).resize(function(e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(sparklineDraw, 200);
            });

            sparklineDraw();           
        }        
    }    

})(); 