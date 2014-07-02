<?php
include_once dirname( __FILE__ ) . '/../includes/header.php';

page_title($page_title, 'dashicons dashicons-admin-media');

/*
	Instead of using a model for media, we can acess the files directly,
	because this is certainly to be the only place where we catalog them,
	and because uploading processes are handled by a library.
	It is simple enough, in any case.
 */


function printMediaRows () {
	// Define the path to the media files.
	$filepath = PUBLICPATH . "media/";
	// For each media file in the file path, print a row.
	foreach ( new DirectoryIterator( $filepath ) as $fileInfo ) {
		if ( $fileInfo->isDot() ) continue;
		if ( $fileInfo->isFile() && $fileInfo->getFileName() !== '.DS_Store' ) {
			$filename = $fileInfo->getFilename();


			echo "<tr>";
			echo "<td>$filename</td>";
			echo "<td>";
			// Show thumbnail, if one exists.
			if (is_readable($filepath . "thumbnail/$filename")) {
				echo "<img src=\"/{$filepath}thumbnail/$filename\">";
			} else {
				echo "<p>No preview available</p>";
			}
			echo "</td>";
			echo "<td><a class=\"edit-page-action\" href=\"/admin/delete-media/$filename\">" .
				"<span class=\"dashicons dashicons-trash\"></span> Delete</a></td>";
		}
	}
}

?>

<div>
    <table class="table admin-table">
        <thead>
            <th>Filename</th>
            <th>File preview</th>
            <th colspan="4" style="text-align:center">Actions</th>
        </thead>
       	<tbody>
       		<?php printMediaRows (); ?>
       	</tbody>

     </table>
</div>

<?php

include_once dirname( __FILE__ ) . '/../includes/footer.php';
?>
