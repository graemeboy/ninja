<?php namespace ninja\Routes;

// $router->get('/auth/', function () use ($auth) {
// 	$auth->index();
// });

// $router->get('/auth', function () use ($auth) {
// 	$auth->index();
// });

$router->get('/auth/sign-out', function () use ($auth) {
	$auth->signOut();
});

$router->get('/' . SIGNIN_PATH, function () use ($auth) {
	$auth->signIn();
});

$router->post('/' . SIGNIN_PATH, function () use ($router, $auth) {
	$auth->processSignIn( $router->request->post() );
});

?>