<video id="player_a" class="projekktor" poster="/assets/plugins/projekktor-1.3.09/media/intro.png" title="this is projekktor" width="640" height="360" controls>
    <!--source src="/assets/plugins/projekktor-1.3.09/media/intro.ogv" type="video/ogg" />
    <source src="/assets/plugins/projekktor-1.3.09/media/intro.mp4" type="video/mp4" /-->
    <!--source src="http://www.youtube.com/watch?v=emvpc0N0WR4" type="video/youtube"/-->
</video>
<script type="text/javascript">
$(document).ready(function() {
    var player = projekktor('#player_a', {
		volume: 1,
		//autoplay: true,
		//continuous: true,
		//loop: true
                playerFlashMP4:         '/assets/plugins/projekktor/swf/Jarisplayer/jarisplayer.swf',
                playerFlashMP3:         '/assets/plugins/projekktor/swf/Jarisplayer/jarisplayer.swf',
    });

    /*player.setItem
    (
    	{src: 'http://www.youtube.com/watch?v=emvpc0N0WR4', type: 'video/youtube'}
    );*/
    player.setItem
    (
    	{
    		src: '/assets/plugins/projekktor/media/intro.mp4',
    		type: 'video/mp4',
    	}
    );
/*
    player.setFile
    ([
    	/*
    	{
    		src: '/assets/plugins/projekktor-1.3.09/media/intro.ogv',
    		type: 'video/ogg'
    	},
    	{
    		src: '/assets/plugins/projekktor-1.3.09/media/intro.ogv',
    		type: 'video/ogg'
    	}
    	
    	{
    		src: '/assets/video/EPIC-Jump.mp4',
    		type: 'video/mp4'
    	},
    	{
    		src: '/assets/video/Vine-The-Dolphin.mp4',
    		type: 'video/mp4'
    	},
        {
            src: '/assets/video/Vine-Miley-Cyrus-likes-corn.mp4',
            type: 'video/mp4'
        },*/
  //      {src: 'http://www.youtube.com/watch?v=emvpc0N0WR4', type: 'video/youtube'}
        /*{
            src: 'http://www.youtube.com/watch?v=AJ0mo9wFU-Y',
            type: 'video/youtube'
        }*//*,
        {
            src: 'http://www.archive.org/download/BenLighthisSurfClubBoys/BenLighthisSurfClubBoys-ImGoingtoGetMeaRobotMandouble-entendrepartyrecord1940s.mp3',
            type: 'audio/mp3'
        },
        {
            src: 'http://archive.org/download/BennyBell/BennyBell-DownBytheOldMillStreamdouble-entendrepartyrecord1940s.mp3',
            type: 'audio/mp3'
        },
        {
            src: 'http://www.djjeremyproductions.com/mp3/DJ%20Jeremy%201940s%20Mix.mp3',
            type: 'audio/mp3'
        },
        {
            src: 'http://archive.org/download/BenLighthisSurfClubBoys/BenLighthisSurfClubBoys-ImGoingtoGetMeaRobotMandouble-entendrepartyrecord1940s.mp3',
            type: 'audio/mp3'
        },
        {
            src: 'http://www.archive.org/download/BennyBell/BennyBell-ShesSoCleverdouble-entendrepartyrecord1940s.mp3',
            type: 'audio/mp3'
        },
        {
            src: 'http://www.archive.org/download/BennyBell/BennyBell-GoTakeaShipforYourself.mp3',
            type: 'audio/mp3'
        },
        {
            src: 'http://www.comicweb.com/podcasts/09-08-29_BostonBlackie_ep58_429.mp3',
            type: 'audio/mp3'
        },
        {
            src: 'http://media.libsyn.com/media/bigband/bigband148.mp3',
            type: 'audio/mp3'
        },
        {
            src: 'http://www.archive.org/download/BennyBell/BennyBell-WhyBuyaCowWhenMilkisCheapdouble-entendrepartyrecord1940s.mp3',
            type: 'audio/mp3'
        },
        {
            src: 'http://www.archive.org/download/CliffEdwards/CliffEdwards-MrInsuranceMandouble-entendrepartyrecord1940s.mp3',
            type: 'audio/mp3'
        }*/
 /*   ]);/*
    player.setCuePoint({
		id: 'words1',
		item: '*',
		group: 'cue3',
		on: '00:02',
		value: 'hallo baby',
		callback: function() {
			//player.setPlayhead('+5');
			//var count = player.getItemCount();
			//var cur = player.getItemIdx();
			//var next = rand(0,count-1);
			//console.log('Count:'+count);
			//console.log('Cur:'+cur);
			//console.log('Next:'+next);
			//player.setActiveItem(player.getItemIdx(0));
			//player.setActiveItem('next');
		}
	});*/
/*
	setInterval(
		function(){
			player.setActiveItem('next');
			//player.setPlayhead('+'+rand(1,4));
		},
		1000
	);
*/
});
</script> 