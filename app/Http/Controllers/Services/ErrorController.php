<?php
    namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Services;

    use ITATS\PraktikumTeknikSipil\App\Config;
    use ITATS\PraktikumTeknikSipil\App\View;

    class ErrorController {
        function error403() {
            http_response_code(403);
            $model = [];

            View::render('errors.403', $model);
        }

        function error404() {
            http_response_code(404);
            $model = [];

            View::render('errors.404', $model);
        }
        
        function error500() {
            http_response_code(500);
            $model = [];

            View::render('errors.500', $model);
        }

        function payment() {
            $model = [];

            View::render('errors.payment', $model);
        }

        function maintenance() {
            $model = [];

            View::render('errors.maintenance', $model);
        }
    }
?>
