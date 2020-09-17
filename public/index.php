<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

function pythonRunner($argString)
{
	$command = 'python3 server/pa-cli.py ' . $argString;
	exec($command, $pythonOutput);

	return $pythonOutput;
}

function getParamValue($request, $paramName)
{
	$params = $request->getQueryParams();
	$paramValue = $params[$paramName];

	return $paramValue;
}

$app = AppFactory::create();

require 'ctrlr_datetime.php';

/**
 * @api {get} / This is executed if no endpoint is specified.
 * @apiGroup Default
 */
function get_default($app)
{
	$app->get('/', function ($request, $response, $args) {
		$response->getBody()->write("The service is running.");

		return $response;
	});
}

// Init all the endpoints.
get_doe($app);
get_cd_to_dn($app);
get_gd_to_jd($app);
get_jd_to_gd($app);
get_ct_to_dh($app);
get_dh_to_ct($app);
get_lct_to_ut($app);
get_ut_to_lct($app);
get_ut_to_gst($app);
get_gst_to_ut($app);
get_gst_to_lst($app);
get_lst_to_gst($app);
get_default($app);

$app->addRoutingMiddleware();

// Set displayErrorDetails to false for production.
$app->addErrorMiddleware(true, true, true);

$app->run();
