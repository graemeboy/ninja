<?php namespace ninja\Routes;

// Admin Index
$router->get( '/' . ADMIN_PATH, function () use ( $admin ) {
		$admin->index( );
	} );
$router->get( '/' . ADMIN_PATH . '/', function () use ( $admin ) {
		$admin->index( );
	} );
// Admin Dashboard
$router->get( '/' . ADMIN_PATH . '/dashboard', function () use ( $admin ) {
		$admin->dashboard( );
	} );
// Add Posts and Pages and Media
$router->get( '/' . ADMIN_PATH . '/add-post', function () use ( $admin ) {
		$admin->addPost( );
	} );
$router->get( '/' . ADMIN_PATH . '/add-page', function () use ( $admin ) {
		$admin->addPage( );
	} );
$router->get( '/' . ADMIN_PATH . '/add-media', function () use ( $admin ) {
		$admin->addMedia( );
	} );
// Manage Posts, Pages, and Media
$router->get( '/' . ADMIN_PATH . '/edit-posts/:slug', function ( $slug ) use ( $admin ) {
		$admin->editPost( $slug );
	} );
$router->get( '/' . ADMIN_PATH . '/edit-posts', function () use ( $admin ) {
		$admin->managePosts( );
	} );
$router->get( '/' . ADMIN_PATH . '/edit-pages/:slug', function ( $slug ) use ( $admin ) {
		$admin->editPage( $slug );
	} );
$router->get( '/' . ADMIN_PATH . '/edit-pages', function () use ( $admin ) {
		$admin->managePages( );
	} );
$router->get( '/' . ADMIN_PATH . '/manage-media', function () use ( $admin ) {
		$admin->manageMedia( );
	} );

// Settings Pages
$router->get( '/' . ADMIN_PATH . '/settings-site', function () use ( $admin ) {
		$admin->settingsSite( );
	} );
$router->get( '/' . ADMIN_PATH . '/settings-admin', function () use ( $admin ) {
		$admin->settingsAdmin ( );
	} );
// Appearance Settings - Theme and Styles
$router->get( '/' . ADMIN_PATH . '/layout', function () use ( $admin ) {
		$admin->layout( );
	} );
$router->get( '/' . ADMIN_PATH . '/style', function () use ( $admin ) {
		$admin->style( );
	} );
// Appearance Settings - Menu
$router->get( '/' . ADMIN_PATH . '/menu', function () use ( $admin ) {
		$admin->menu( );
	} );
// Appearance Settings - Widgets
$router->get( '/' . ADMIN_PATH . '/sidebar', function () use ( $admin ) {
		$admin->sidebar( );
	} );
// .htaccess
$router->get( '/' . ADMIN_PATH . '/htaccess', function () use ( $admin ) {
		$admin->htaccess( );
	} );
$router->post( '/' . ADMIN_PATH . '/htaccess', function () use ( $admin ) {
		$admin->updateHtaccess();
	} );
// Sitemap
$router->get('/' . ADMIN_PATH . '/sitemap', function () use ( $admin ) {
	$admin->sitemap();
});
// Delete post
$router->get( '/' . ADMIN_PATH . '/delete-post/:slug', function ( $slug ) use ( $admin, $router ) {
		$admin->deletePost( $slug );
		$router->redirect( '/' . ADMIN_PATH . '/edit-posts' );
	} );
// Delete page
$router->get( '/' . ADMIN_PATH . '/delete-page/:slug', function ( $slug ) use ( $admin, $router ) {
		$admin->deletePage( $slug );
		$router->redirect( '/' . ADMIN_PATH . '/edit-pages' );
	} );
// Delete media
$router->get( '/' . ADMIN_PATH . '/delete-media/:slug', function ( $slug ) use ( $admin, $router ) {
		$admin->deleteMedia( $slug );
		$router->redirect( '/' . ADMIN_PATH . '/manage-media' );
	} );
// View post - redirect
$router->get( '/' . ADMIN_PATH . '/view-post/:slug', function ( $slug ) use ( $router ) {
		$router->redirect( "/$slug" );
	} );

?>
