<?php namespace ninja\Routes;

// Admin Index
$router->get( '/admin', function () use ( $admin ) {
		$admin->index( );
	} );
$router->get( '/admin/', function () use ( $admin ) {
		$admin->index( );
		exit;
	} );
// Admin Dashboard
$router->get( '/admin/dashboard', function () use ( $admin ) {
		$admin->dashboard( );
	} );
// Add Posts and Pages and Media
$router->get( '/admin/add-post', function () use ( $admin ) {
		$admin->addPost( );
	} );
$router->get( '/admin/add-page', function () use ( $admin ) {
		$admin->addPage( );
	} );
$router->get( '/admin/add-media', function () use ( $admin ) {
		$admin->addMedia( );
	} );
// Manage Posts, Pages, and Media
$router->get( '/admin/edit-posts/:slug', function ( $slug ) use ( $admin ) {
		$admin->editPost( $slug );
	} );
$router->get( '/admin/edit-posts', function () use ( $admin ) {
		$admin->managePosts( );
	} );
$router->get( '/admin/edit-pages/:slug', function ( $slug ) use ( $admin ) {
		$admin->editPage( $slug );
	} );
$router->get( '/admin/edit-pages', function () use ( $admin ) {
		$admin->managePages( );
	} );
$router->get( '/admin/manage-media', function () use ( $admin ) {
		$admin->manageMedia( );
	} );

// Settings Pages
$router->get( '/admin/settings-site', function () use ( $admin ) {
		$admin->settingsSite( );
	} );
$router->get( '/admin/settings-admin', function () use ( $admin ) {
		$admin->settingsAdmin ( );
	} );
// Appearance Settings - Theme and Styles
$router->get( '/admin/layout-style', function () use ( $admin ) {
		$admin->layoutStyle( );
	} );
// Appearance Settings - Menu
$router->get( '/admin/menu', function () use ( $admin ) {
		$admin->menu( );
	} );
// Appearance Settings - Widgets
$router->get( '/admin/sidebar', function () use ( $admin ) {
		$admin->sidebar( );
	} );
// Delete post
$router->get( '/admin/delete-post/:slug', function ( $slug ) use ( $admin, $router ) {
		$admin->deletePost( $slug );
		$router->redirect( '/admin/edit-posts' );
	} );
// Delete page
$router->get( '/admin/delete-page/:slug', function ( $slug ) use ( $admin, $router ) {
		$admin->deletePage( $slug );
		$router->redirect( '/admin/edit-pages' );
	} );
// Delete media
$router->get( '/admin/delete-media/:slug', function ( $slug ) use ( $admin, $router ) {
		$admin->deleteMedia( $slug );
		$router->redirect( '/admin/manage-media' );
	} );
// View post - redirect
$router->get( '/admin/view-post/:slug', function ( $slug ) use ( $router ) {
		$router->redirect( "/$slug" );
	} );
?>
