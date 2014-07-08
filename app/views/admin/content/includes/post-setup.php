<div class="container-fuid">
    <div class="row">
    <div class="col-sm-10">
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
    <div class="col-sm-2">
        <?php include('save-button.php') ?>
    </div>

    <div id="page-notification">
        <?php include ( APPPATH . 'views/admin/includes/notification.htm'); ?>
    </div>
</div>
    <h3 style="margin-left:5px">Add External Media Content</h3>
        <p style="margin-left:5px">This content is related to post tags.</p>
        <div class="panel admin-panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    Youtube Videos
                </h4>
            </div>
            <div>
                <div id="vids" class="panel-body">
                </div>
            </div>
        </div>
        <div class="panel admin-panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                      Google Images
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
              <div id="images" class="panel-body">
              </div>
            </div>
        </div>
      <div class="panel admin-panel">
        <div class="panel-heading">
          <h4 class="panel-title">
              Popular Articles
          </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
          <div id="articles" class="panel-body">
          </div>
        </div>
</div>

</div>
<!-- Include google client script -->
<script src="https://www.google.com/jsapi"></script>

<script type="text/javascript">
/*
    Embed actions - Clicking on the "Embed" button.
 */

/**
 * The action performed when the embed video button is clicked.
 * 
 * @param  element self the element of the button
 */

function embedVideoClick(self) {
    var itemToEmbed, embedCode;
    // Get the ID of the video
    itemToEmbed = $(self).attr("data-video");
    // Create the embed code
    embedCode = youtubeEmbedCode(itemToEmbed);
    // Embed the video in the post content.
    $('#edit-content').val($('#edit-content').val() + "\n\n" + embedCode);
} // embedVideoClick

/**
 * Takes a video idea and returns the embed code
 * @param  string videoID the ID for a YouTube video
 * @return string the iFrame embed code
 */
function youtubeEmbedCode (videoID)  {
    return '<iframe width="400" height="315" src="//www.youtube.com/embed/' + 
        videoID + '" frameborder="0" allowfullscreen></iframe>';
} // youtubeEmebedCode

// Defined whether to automatically set tags based on title.
var setTags = true;
// Set the content type to page, not post.
var contentType = "post";

/**
 * Briliant script written by J.
 * Motified for integration into package by G.
 */

/*  ----------------------
        Fields
    ----------------------
 */
var imageSearch;
var googleClientAPI = 'AIzaSyAkgodW46UpahLkm0pNT-Gb2fwVDTjsUO0';
// Create a boolean for blocking using the API.
var useAPI = false;

/*  -----------------------
        Initialization
    -----------------------
 */
// Initialize Google client for image search (using deprecated API).
google.load('search', '1');
google.setOnLoadCallback(OnLoad);


/*  -----------------------
        Init. Methods
    -----------------------
 */
/**
 * Initialize Google client (for current apis).
 */
function onClientLoad() {
    // set api key, then call function to load youtube api
    gapi.client.setApiKey(googleClientAPI);
    window.setTimeout(function () {
        loadYoutubeApi();
    },1);
} // onClientLoad

/**
 * Set up Google client for image search.
 */
function OnLoad() {
    // New instance of Google->Search->ImageSearch.
    imageSearch = new google.search.ImageSearch();

    // Use imageSearchComplete as callback when image search terminates.
    imageSearch.setSearchCompleteCallback(this, imageSearchComplete, null);
    
    // Set usage rights restrictions to return only images that can be used .
    imageSearch.setRestriction(google.search.ImageSearch.RESTRICT_RIGHTS,
                               google.search.ImageSearch.RIGHTS_REUSE);
} // OnLoad

/**
 * Load YouTube API.
 */
function loadYoutubeApi() {
    gapi.client.load('youtube', 'v3', function() {
        // initalize submit button
        $('input[type="submit"]').removeAttr('disabled');
    })
} // loadYoutubeApi

/*  -----------------------
        Video Search
    -----------------------
 */
function searchVideo (q) {
    // execute youtube search, then execute callback 
    var request = gapi.client.youtube.search.list({
        q: q,
        part: 'snippet',
        type: 'video',
        videoEmbeddable: 'true',
        videoSyndicated: 'true'
    });
    request.execute(videoSearchComplete);
} // searchVideo()

// callback for adding video results to page
function videoSearchComplete(response) {
    
    // make sure we have video results
    if (response.items && response.items.length > 0) {
        // clear videos div
        $('#vids').html('')
        results = response.items;
        
        var embedCode, displayCode, embedWrapped, embedActions, actionButton, 
            codeWrapper, row, colFrame, colAction, vids;
        // iterate through results and add them to videos div
        for (var i = 0; i < results.length; i++) {
            // set up embed code using defalt youtube embed settings
            embedCode = youtubeEmbedCode(results[i].id.videoId);
            // clean up embed code to display on page
            displayCode = embedCode.replace("<", "&lt;").replace(">", "&gt;");
            // define some actions for the video
            
            // Action button
            actionButton = document.createElement('a');
            actionButton.className = "btn btn-info embed-video-button";
            actionButton.innerHTML = "Add to Post";
            actionButton.href = "#";
            $(actionButton).attr('data-video', results[i].id.videoId);

            // Add an action listener to the button.
            $(actionButton).click(function (event) {
                event.preventDefault();
                embedVideoClick(this);
            });

            // Actions wrapper
            embedActions = document.createElement('div');
            embedActions.className = "embed-actions";
            embedActions.appendChild(actionButton);

            // Embed code wrapper
            codeWrapper = document.createElement('div');
            codeWrapper.className = "embed-code";
            codeWrapper.innerHTML = displayCode;

            // Label for code
            embedLabel = document.createElement('strong');
            embedLabel.innerHTML = "Embed Code:";
            // Embed wrapper as a whole
            embedWrapped = document.createElement('div');
            embedWrapped.appendChild(embedLabel);
            embedWrapped.appendChild(codeWrapper);
            embedWrapped.appendChild(embedActions);

            // Row for embed item
            row = document.createElement('div');
            row.className = "row embed-item";

            // Column for iframe
            colFrame = document.createElement('div');
            colFrame.className = "col-md-5";
            colFrame.innerHTML = embedCode;

            // Column for actions
            colAction = document.createElement('div');
            colAction.className = "col-md-7";
            colAction.appendChild(embedWrapped);

            // Append the columns to the row
            row.appendChild(colFrame);
            row.appendChild(colAction);

            vids = document.getElementById('vids');
            vids.appendChild(row);
            
            
            // append video and embed code to videos div
            
            //$('#vids').append('<div class="row embed-item"><div class="col-md-5">' + embedCode + '</div>' + '<div class="col-md-7">' + embedWrapped + '</div>');
    } // for

  } // if
} // videoSearchComplete


/*  ---------------------
        Image Search
    ---------------------
 */
function performSearch () {
    var values = $( "#edit-tags" ).val();
    // youtube and google image search takes a string with all keywords separated by spaces
    var query = values.replace(",", " ");
    searchVideo(query);

    // execute youtube and google image search
    //googleSearch(query);
    
    // wikipedia article search takes an array of the tags
    // values = values.split(","); 
    // values = values.map(function (el) {
    //     return el.trim();
    // });
    // // execute search on wikipedia
    // wikiSearch(values);
}

/**
 * Callback for adding image results to page.
 */
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
  //imageSearch.execute(q);
  
  
} // googleSearch
    
/**
 * Scrape references from wikipedia for each query tag.
 * @param  array q an array of strings for querying.
 */
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
<script src="https://apis.google.com/js/client.js?onload=onClientLoad"></script>

