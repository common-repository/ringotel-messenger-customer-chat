jQuery(document).ready(function() {

	if(!plugin_options || !plugin_options.page_id) {
		console.error('plugin_options is undefined');
		return;
	}

	console.log('plugin_options: ', plugin_options);

	var appId = '195940994296837';
	var version = 'v2.11';
	// var version = plugin_options.api_version || 'v2.11';
	var page_id = plugin_options.page_id;
	var locale = plugin_options.locale || 'en_US';

	loadFbSDK();
	loadFbWidget();

	function loadFbSDK() {
	    window.fbAsyncInit = function() {
	        FB.init({
	            appId      : appId,
	            xfbml      : true,
	            version    : version
	        });
	        FB.AppEvents.logPageView();
	    };

	    (function(d, s, id){
	        var js, fjs = d.getElementsByTagName(s)[0];
	        if (d.getElementById(id)) {return;}
	        js = d.createElement(s); js.id = id;
	        js.src = "//connect.facebook.net/"+locale+"/sdk.js";
	        fjs.parentNode.insertBefore(js, fjs);
	    }(document, 'script', 'facebook-jssdk'));
	}

	function loadFbWidget() {
	    var html = '<div class="fb-customerchat" page_id="'+page_id+'" minimized="true"></div> ';

	    document.body.insertAdjacentHTML('beforeend', html);
	}

});