<?php

/**
 * @api {get} /doe/{year} Calculate date of Easter for a given year.
 * @apiGroup DateTime
 * 
 * @apiParam {int} year Input year.
 */
function get_doe($app)
{
	$app->get('/doe/{year}', function ($request, $response, $args) {
		$year_value = $args['year'];

		$pythonOutput = pythonRunner('--doe --year ' . $year_value);

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}

/**
 * @api {get} /cdtodn?inputDate={inputDate} Calculate day number for a civil date.
 * @apiGroup DateTime
 * 
 * @apiParam {string} inputDate Civil date.
 */
function get_cd_to_dn($app)
{
	$app->get('/cdtodn', function ($request, $response, $args) {
		$civil_date = getParamValue($request, 'inputDate');

		$pythonOutput = pythonRunner('--cd_to_dn --cd "' . $civil_date . '"');

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}

/**
 * @api {get} /gdtojd?inputDate={inputDate} Calculate Julian date for a Greenwich date.
 * @apiGroup DateTime
 * 
 * @apiParam {string} inputDate Greenwich date, e.g. "2/1/2019"
 */
function get_gd_to_jd($app)
{
	$app->get('/gdtojd', function ($request, $response, $args) {
		$greenwich_date = getParamValue($request, 'inputDate');

		$pythonOutput = pythonRunner('--gd_to_jd --gd "' . $greenwich_date . '"');

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}

/**
 * @api {get} /jdtogd?julianDate={julianDate} Calculate Greenwich date for a Julian date.
 * @apiGroup DateTime
 * 
 * @apiParam {float} julianDate Julian date, e.g. 2455002.25
 */
function get_jd_to_gd($app)
{
	$app->get('/jdtogd', function ($request, $response, $args) {
		$julian_date = getParamValue($request, 'julianDate');

		$pythonOutput = pythonRunner('--jd_to_gd --jd ' . $julian_date);

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}

/**
 * @api {get} /cttodh?civilTime={civilTime} Calculate decimal hours for a given civil time.
 * @apiGroup DateTime
 * 
 * @apiParam {string} civilTime Civil time, e.g. 18:32:00
 */
function get_ct_to_dh($app)
{
	$app->get('/cttodh', function ($request, $response, $args) {
		$civil_time = getParamValue($request, 'civilTime');

		$pythonOutput = pythonRunner('--ct_to_dh --ct ' . $civil_time);

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}

/**
 * @api {get} /dhtoct?decimalHours={decimalHours} Calculate civil time for decimal hours.
 * @apiGroup DateTime
 * 
 * @apiParam {float} decimalHours Decimal hours, e.g. 18.53333333
 */
function get_dh_to_ct($app)
{
	$app->get('/dhtoct', function ($request, $response, $args) {
		$decimal_hours = getParamValue($request, 'decimalHours');

		$pythonOutput = pythonRunner('--dh_to_ct --dh ' . $decimal_hours);

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}

/**
 * @api {get} /lcttout?localCivilDate={localCivilDate}&localCivilTime={localCivilTime}&zoneCorrection={zoneCorrection}&isDST={isDST} Calculate universal time for local civil time.
 * @apiGroup DateTime
 * 
 * @apiParam {string} localCivilDate Local civil date, e.g., 7/1/2013
 * @apiParam {string} localCivilTime Local civil time, e.g. 3:37:00
 * @apiParam {int} zoneCorrection Zone correction (offset), e.g. 4
 * @apiParam {string} isDST Is Daylight Savings?  Valid values: "Y" or "N"
 */
function get_lct_to_ut($app)
{
	$app->get('/lcttout', function ($request, $response, $args) {
		$local_civil_date = getParamValue($request, 'localCivilDate');
		$local_civil_time = getParamValue($request, 'localCivilTime');
		$zone_correction = getParamValue($request, 'zoneCorrection');
		$is_dst = getParamValue($request, 'isDST');
		if ($is_dst == 'Y') {
			$is_dst_param = "--dst";
		} else {
			$is_dst_param = "--st";
		}

		$pythonOutput = pythonRunner('--lct_to_ut --cd ' . $local_civil_date . ' --ct ' . $local_civil_time . ' --zc ' . $zone_correction . ' ' . $is_dst_param);

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}

/**
 * @api {get} /uttolct?civilDate={civilDate}&universalTime={universalTime}&zoneCorrection={zoneCorrection}&isDST={isDST} Calculate local civil time for universal time.
 * @apiGroup DateTime
 * 
 * @apiParam {string} civilDate Civil date, e.g., 6/30/2013
 * @apiParam {string} universalTime Universal time, e.g. 22:37:00
 * @apiParam {int} zoneCorrection Zone correction (offset), e.g. 4
 * @apiParam {string} isDST Is Daylight Savings?  Valid values: "Y" or "N"
 */
function get_ut_to_lct($app)
{
	$app->get('/uttolct', function ($request, $response, $args) {
		$civil_date = getParamValue($request, 'civilDate');
		$universal_time = getParamValue($request, 'universalTime');
		$zone_correction = getParamValue($request, 'zoneCorrection');
		$is_dst = getParamValue($request, 'isDST');
		if ($is_dst == 'Y') {
			$is_dst_param = "--dst";
		} else {
			$is_dst_param = "--st";
		}

		$pythonOutput = pythonRunner('--ut_to_lct --cd ' . $civil_date . ' --ut ' . $universal_time . ' --zc ' . $zone_correction . ' ' . $is_dst_param);

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}

/**
 * @api {get} /uttogst?universalTime={universalTime}&greenwichDate={greenwichDate} Calculate Greenwich sidereal time for universal time.
 * @apiGroup DateTime
 * 
 * @apiParam {string} universalTime Universal time, e.g. 14:36:51.67
 * @apiParam {string} greenwichDate Greenwich date, e.g., 4/22/1980
 */
function get_ut_to_gst($app)
{
	$app->get('/uttogst', function ($request, $response, $args) {
		$universal_time = getParamValue($request, 'universalTime');
		$greenwich_date = getParamValue($request, 'greenwichDate');

		$pythonOutput = pythonRunner('--ut_to_gst --ut ' . $universal_time . ' --gd ' . $greenwich_date);

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}

/**
 * @api {get} /gsttout?greenwichSiderealTime={greenwichSiderealTime}&greenwichDate={greenwichDate} Calculate universal time for Greenwich sidereal time.
 * @apiGroup DateTime
 * 
 * @apiParam {string} greenwichSiderealTime Greenwich sidereal time, e.g. 4:40:5.23
 * @apiParam {string} greenwichDate Greenwich date, e.g., 4/22/1980
 */
function get_gst_to_ut($app)
{
	$app->get('/gsttout', function ($request, $response, $args) {
		$greenwich_sidereal_time = getParamValue($request, 'greenwichSiderealTime');
		$greenwich_date = getParamValue($request, 'greenwichDate');

		$pythonOutput = pythonRunner('--gst_to_ut --gst ' . $greenwich_sidereal_time . ' --gd ' . $greenwich_date);

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}

/**
 * @api {get} /gsttolst?greenwichSiderealTime={greenwichSiderealTime}&geographicalLongitude={geographicalLongitude} Calculate local sidereal time for Greenwich sidereal time.
 * @apiGroup DateTime
 * 
 * @apiParam {string} greenwichSiderealTime Greenwich sidereal time, e.g. 4:40:5.23
 * @apiParam {float} geographicalLongitude Geographical longitude, e.g., -64
 */
function get_gst_to_lst($app)
{
	$app->get('/gsttolst', function ($request, $response, $args) {
		$greenwich_sidereal_time = getParamValue($request, 'greenwichSiderealTime');
		$geographical_longitude = getParamValue($request, 'geographicalLongitude');

		$pythonOutput = pythonRunner('--gst_to_lst --gst ' . $greenwich_sidereal_time . ' --gl ' . $geographical_longitude);

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}

/**
 * @api {get} /lsttogst?localSiderealTime={localSiderealTime}&geographicalLongitude={geographicalLongitude} Calculate Greenwich sidereal time for local sidereal time.
 * @apiGroup DateTime
 * 
 * @apiParam {string} localSiderealTime Local sidereal time, e.g. 0:24:5.23
 * @apiParam {float} geographicalLongitude Geographical longitude, e.g., -64
 */
function get_lst_to_gst($app)
{
	$app->get('/lsttogst', function ($request, $response, $args) {
		$local_sidereal_time = getParamValue($request, 'localSiderealTime');
		$geographical_longitude = getParamValue($request, 'geographicalLongitude');

		$pythonOutput = pythonRunner('--lst_to_gst --lst ' . $local_sidereal_time . ' --gl ' . $geographical_longitude);

		$response->getBody()->write($pythonOutput[0]);

		return $response;
	});
}
