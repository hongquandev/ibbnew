/*
* 	Copyright by Tuong Nguyen
*	Company GOS Vietnam - 57 Lam Hoang Street - Hue
*
*	Example: 
*	Cufon.replace('.learn-section li a', {
*		hover: true,
*		fontFamily: 'Klavika Regular'
*	});
*
*
*/




function replaceCufon()
{
	if (window['Cufon'] != undefined || document['Cufon'] != undefined)
		{
			Cufon.replace('#test-cufon','.lightbox-cufon, .cufon, .cufonbold, .product-name h1, .button span span, .page-title h1, .nav a, #nav a,h2,.my-account h3, #lanc span, .h1-cufon,', {hover:true, fontFamily: 'Neutra Text' });
			/*
			Cufon.replace('.button span span', {hover:true, fontFamily: 'Neutra Text' });
			Cufon.replace('.page-title h1', {hover:true, fontFamily: 'Neutra Text' });
			*/
		}
};

