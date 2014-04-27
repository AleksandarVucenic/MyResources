/**
 * -----------------------------------------------------------
 * Test for appling for job, "Junior Web Developer."  
 * JS (JavaScript) for "Sign Up Landing Page Form
 * YOUTUBE Manager
 * -----------------------------------------------------------
 * @author: Aleksandar Vučenić; 
 * -----------------------------------------------------------
 */

var YVideo = 
{
	contaner:   'player',
	videoId:    null,
	self: this,
	// Default parametars
	YTParametars:{
		basicParametars:  { height: null, width: null },
		playerParametars: { autohide: 0, autoplay:0, controls:1, showinfo:1, rel:1, modestbranding: 1, wmode:'transparent' },
		eventsParametars: { onReady:'videoReady', onStateChange:'videoEnd' },
	},
	
	// Add Video ID
	addVideo: function(videoId)
	{
		this.videoId = videoId;
		return this;
	},

	// Add Parametars For YT
	addParametars: function(parametars)
	{
		//alert(Array parametars.lenght);
		if(parametars instanceof Object)
		{
			for (var key in parametars) {
				this.YTParametars.playerParametars[key] = parametars[key];
				//alert(key +' | '+ parametars[key]);
			}
		}

		return this;
	},

	// Add Events to Youtube
	addEvents: function(events)
	{
		if(events instanceof Object)
		{
			for (var key in events) {
				this.YTParametars.eventsParametars[key] =  events[key] ;
			}
		}
	},

	// Adding container for youtube video
	addContainer: function(container)
	{
		this.container = container;
		return this;
	},

	// Render Output YT Video
	renderVideo: function()
	{
		var parent = $('#head-wrapper');
		parent.append(
			'<div  class="youtube-container">' +
				'<div id="'+this.videoId+'" class="youtube-video"></div>' +
				'<div class="youtube-exit"  onClick="removeYTXcontainer()">X</div>' +
			'</div>'
		);

		player = new YT.Player( this.videoId,{
				/* Basic Settings */
				videoId: this.videoId,

				/* Player Parameters */
				playerVars: { 
					autohide:       this.YTParametars.playerParametars.autohide,
					autoplay:       this.YTParametars.playerParametars.autoplay,
					controls:       this.YTParametars.playerParametars.controls,
					showinfo:       this.YTParametars.playerParametars.showinfo,
					rel:            this.YTParametars.playerParametars.rel,
					modestbranding: this.YTParametars.playerParametars.modestbranding,
					wmode:          this.YTParametars.playerParametars.wmode,
				},

				/* Player Events */
				events:{
					'onReady':       this.YTParametars.eventsParametars.onReady,
					'onStateChange': this.YTParametars.eventsParametars.onStateChange,
				}
				
			}
		);
	},

}


// Render when video ready
function videoReady(event){

}

//Render when video end
function videoEnd(event){

	if(event.data === 0)
	{
		var element = $( '#' + YVideo.videoId ).closest('.youtube-container');
		element.delay(100).fadeOut().queue(function(){
			element.delay(5000).remove();
		});
	}
	
}
