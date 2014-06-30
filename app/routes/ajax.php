<?php namespace ninja\Routes;
/**
 * AJAX Routes
 */

$router->post( '/admin/ajax', function () use ( $router, $admin ) {
		$admin->ajaxRequest( $router->request->post() );
	} );

?>
