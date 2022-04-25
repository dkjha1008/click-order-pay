<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		
		<title>ClickOrderPay - UT Austin's Fastest Delivery Service</title> 
		<meta name="description"content="The fastest 15-minute delivery service made for students, by students.">

		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-T4SM4K4');</script>
		<!-- End Google Tag Manager -->

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-188537512-1">
		</script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-188537512-1');
		</script>
		
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

		<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/favicons(57_57).png') }}">
		<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/favicons(114_114).png') }}">
		<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/favicons(72_72).png') }}">
		<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/favicons(114_114).png') }}">
		<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/favicons(60_60).png') }}">
		<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/favicons(120_120).png') }}">
		<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/favicons(76_76).png') }}">
		<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/favicons(152_152).png') }}">
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/favicons(180_180).png') }}">

		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
		<link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/all.css') }}">
		<link rel="stylesheet" href="{{ asset('css/slick.css') }}">
		<link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
		<script src="{{ asset('js/jquery.min.js') }}"></script>
		<script src="{{ asset('js/popper.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/fontawsome.js') }}"></script>
		<script src="{{ asset('js/script.js') }}"></script>
		<script src="{{ asset('js/wow.js') }}"></script>
		<script src="{{ asset('js/slick.js') }}"></script>
		<link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
		<script src="{{ mix('/js/app.js') }}" defer></script>
	</head>
	<body>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T4SM4K4"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		@routes
		@inertia
	</body>
</html>


