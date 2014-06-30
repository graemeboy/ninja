<?php namespace ninja\Routes;

// Admin Index
$router->get( '/admin', function () use ( $admin, $router ) {
		$admin->index( $router );
	} );
$router->get( '/admin/', function () use ( $admin, $router ) {
		$admin->index( $router );
	} );
// Admin Dashboard
$router->get( '/admin/dashboard', function () use ( $admin, $router ) {
		$admin->dashboard( $router );
	} );
// Add Posts and Pages and Media
$router->get( '/admin/add-post', function () use ( $admin, $router ) {
		$admin->addPost( $router );
	} );
$router->get( '/admin/add-page', function () use ( $admin, $router ) {
		$admin->addPage( $router );
	} );
$router->get( '/admin/add-media', function () use ( $admin, $router ) {
		$admin->addMedia( $router );
	} );
// Manage Posts, Pages, and Media
$router->get( '/admin/edit-posts/:slug', function ( $slug ) use ( $admin, $router ) {
		$admin->editPost( $router, $slug );
	} );
$router->get( '/admin/edit-posts', function () use ( $admin, $router ) {
		$admin->managePosts( $router );
	} );
$router->get( '/admin/edit-pages', function () use ( $admin, $router ) {
		$admin->managePages( $router );
	} );
$router->get( '/admin/edit-media', function () use ( $admin, $router ) {
		$admin->manageMedia( $router );
	} );

// Settings Pages
$router->get( '/admin/settings-site', function () use ( $admin, $router ) {
		$admin->settingsSite( $router );
	} );
// Appearance Settings - Theme and Styles
$router->get( '/admin/appearance', function () use ( $admin, $router ) {
		$admin->appearance( $router );
	} );
$router->get( '/admin/delete-post/:slug', function ( $slug ) use ( $admin, $router ) {
		$admin->deletePost( $slug );
		$router->redirect( '/admin/edit-posts' );
	} );

$router->get( '/admin/view-post/:slug', function ( $slug ) use ( $router ) {
		$router->redirect( "/$slug" );
	} );
?>
