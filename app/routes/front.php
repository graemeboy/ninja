<?php namespace ninja\Routes;
/**
 * Frontend routes
 */

// Dynamic Routes
// Posts or Pages
$router->get( '/:slug', function ( $slug ) use ( $front, $router ) {
		// Check if post exists.
		$postModel = new \ninja\Models\Post();
		if ( $postModel->isPost( $slug ) ) {
			$front->post( $slug );
		} else {
			// Check Pages
			$pageModel = new \ninja\Models\Page();
			if ( $pageModel->isPage( $slug ) ) {
				// Found a page with this slug.
				$front->page( $slug );
			} else {
				// Return 404
				$router->notFound();
			}
		}
	} );

// Set the 404
$router->notFound( function () use ( $router ) {
		$router->render( '404.php' );
	} );
?>
