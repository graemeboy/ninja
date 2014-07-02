<div class="container">
    <div class="row">
    <div class="col-sm-8">
        <form id="save-content-form" role="form">
            <input type="hidden" name="slug-original" id="slug-original" value="<?php echo $slug ?>" />
            <?php include('edit-title.php') ?>
            <div class="row">
                <div class="col-sm-6">
                    <?php include('edit-slug.php') ?>
                </div>
                <div class="col-sm-6">
                    <?php include('edit-tags.php') ?>
                </div>
            </div>
            <?php include('edit-content.php') ?>
        </form>
    </div>
    <div class="col-sm-4">
        <?php include('save-button.php') ?>
    </div>

    <div id="page-notification">
        <?php include ( APPPATH . 'views/admin/includes/notification.htm'); ?>
    </div>
</div>
</div>
<script type="text/javascript">
// Defined whether to automatically set tags based on title.
var setTags = true;
// Set the content type to page, not post.
var contentType = "post";


/**
 * Script written by J.
 */
// on button submit, prcoess query text and run searches
$( "#edit-tags" ).change(function ( ) {
    var values = $( "#edit-tags" ).val();
    
    // youtube and google image search takes a string with all keywords separated by spaces
    var query = values.replace(",", "");
    // execute youtube and google image search
    googleSearch(query);
    
    // wikipedia article search takes an array of the tags
    values = values.split(","); 
    values = values.map(function (el) {
        return el.trim();
    });
    // execute search on wikipedia
    wikiSearch(values);
});

// $(document).ready(function () {
//     // disable submit button until all apis are loaded
//     $('input[type="submit"]').attr('disabled','disabled');
// }) // ready

// initialize google client (for current apis)
function onClientLoad() {
    // set api key, then call function to load youtube api
    gapi.client.setApiKey('AIzaSyAkgodW46UpahLkm0pNT-Gb2fwVDTjsUO0');
    window.setTimeout(loadYoutubeApi,1);
} // onClientLoad

// load youtube api
function loadYoutubeApi() {
    gapi.client.load('youtube', 'v3', function() {
        // initalize submit button
        $('input[type="submit"]').removeAttr('disabled');
    })
} // loadYoutubeApi

// initialize google client for image search (using deprecated api)
google.load('search', '1');

var imageSearch;

// set up google client for image search
function OnLoad() {
    imageSearch = new google.search.ImageSearch();

    // use imageSearchComplete as callback when image search terminates
    imageSearch.setSearchCompleteCallback(this, imageSearchComplete, null);
    
    // set usage rights restrictions to return only images that can be used 
    imageSearch.setRestriction(google.search.ImageSearch.RESTRICT_RIGHTS,
                               google.search.ImageSearch.RIGHTS_REUSE);
} // OnLoad


google.setOnLoadCallback(OnLoad);

// callback for adding video results to page
function videoSearchComplete(response) {
    
    // make sure we have video results
    if (response.items && response.items.length > 0) {
        // clear videos div
        $('#vids').html('')
        results = response.items;
        
        // iterate through results and add them to videos div
        for (var i = 0; i < results.length; i++) {
            
            // set up embed code using defalt youtube embed settings
            var embedCode = '<iframe width="400" height="315" src="//www.youtube.com/embed/' + results[i].id.videoId + '" frameborder="0" allowfullscreen></iframe>';
            
            // clean up embed code to display on page
            var displayCode = embedCode.replace("<", "&lt;").replace(">", "&gt;");
        
            // append video and embed code to videos div
            $('#vids').append('<div class="row"><div class="col-md-5">' + embedCode + '<</div>' + '<div class="col-md-7"><strong>Embed Code:</strong><pre>' + displayCode + '</pre></div></div>')
    } // for
  } // if
} // videoSearchComplete
    
// callback for adding image results to page
function imageSearchComplete() {

    // make sure we have image results
    if (imageSearch.results && imageSearch.results.length > 0) {
        
        // clear images div
        $('#images').html('');
        results = imageSearch.results;
        
        // iterate through results and add them to images div
        for (var i = 0; i < results.length; i++) {
            $('#images').append('<div class="row"><div class="col-md-5"><img src="' + results[i].url + '" width=400></div><div class="col-md-7"><strong>Image URL:</strong><pre>' + results[i].url + '</pre></div></div>');
        } // for
    } // if
} // imageSearchComplete
    
// calls youtube and google image search
function googleSearch(q) {
  
  // execute initalized image search on query string
  imageSearch.execute(q);
  
 // execute youtube search, then execute callback 
  var request = gapi.client.youtube.search.list({
    q: q,
    part: 'snippet',
    type: 'video',
    videoEmbeddable: 'true',
    videoSyndicated: 'true'
  });
  request.execute(videoSearchComplete);
} // search
    
// scrape references from wikipedia for each query tag
function wikiSearch(q) {
    
    // clear articles div
    $('#articles').html('');

    for (var i = 0; i < q.length; i++) {
        query = q[i]
        
        // search wikipedia via ajax request to api
        $.ajax({
            type: 'GET',
            url: 'http://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=' + encodeURI(query) + '&format=json&callback=?',
            contentType: 'application/json; charset=utf-8',
            async: false,
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                
                // dumb method: just grab the first search result
                var title = data.query.search[0].title;
                
                // load the first result page via ajax request to wiki api
                $.ajax({
                    type: 'GET',
                    url: 'http://en.wikipedia.org/w/api.php?action=parse&page=' + encodeURI(title) + '&format=json&prop=text&callback=?',
                    contentType: 'application/json; charset=utf-8',
                    async: false,
                    dataType: 'json',
                    success: function (page) {
                        
                        // grab the html for the page
                        var wikihtml = page.parse.text['*'];
                        
                        // create a div to control DOM elements
                        var div = document.createElement('div');
                        div.innerHTML = wikihtml;
                        
                        // grab all the links under the references header
                        var elements = div.getElementsByClassName('references')[0].getElementsByTagName('a');
                        
                        // iterate through links and
                        for (var i = 0; i < elements.length; i++) {
                            
                            // make sure link goes to an external site
                            if (elements[i].matches('.external')) {
                                var link = elements[i];
                                // append link to articles div
                                $('#articles').append('<a href="' + link.getAttribute('href') + '"><strong>'+ link.innerHTML + '</strong></a><pre>' + link.getAttribute('href') + '</pre></div></div>');
                            } // if
                        } // for
                    }, // success
                    error: function (errorMessage) {
                        console.log(errorMessage);
                    } // error
                }); // ajax
            }, // success
            error: function (errorMessage) {
                console.log(errorMessage);
            } // error
        }); // ajax
    } // for
} // wikiSearch
</script>
<h3 class="page-title">Add Content</h3>

<div class="container" id="content">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                          Youtube Videos
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div id="vids" class="panel-body">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                          Google Images
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                  <div id="images" class="panel-body">
                  </div>
                </div>
            </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                  Popular Articles
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
              <div id="articles" class="panel-body">
              </div>
            </div>
          </div>
        </div>
    </div>