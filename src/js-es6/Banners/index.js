export default Banners;

function Banners( banners ){
	console.log( 'Banners' );
	if( banners.length > 1 ){
		banners.fadeOut();
		let banner = banners.first().fadeIn();
		setInterval( f => {
			banner = banner.fadeOut().css({position: 'absolute'}).next().css({position: ''}).fadeIn();
			if( !banner.length ) banner = banners.first().css({position: ''}).fadeIn();
		},3000);
	}
};