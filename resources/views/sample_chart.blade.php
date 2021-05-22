<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Chart with VueJS</title>
    </head>
    <body>
        <script src="/js/chart.min.js" charset="utf-8"></script>
        <div id="app">
            {!! $chart->container() !!}
        </div>
        <script src="https://unpkg.com/vue"></script>
        <script>
            var app = new Vue({
                el: '#app',
            });
        </script>
        {!! $chart->script() !!}
    </body>
</html>