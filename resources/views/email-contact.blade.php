<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
	.mail_text{
		padding: 20px;
	}
	.mail_text .logo{
	    width: 50px;
	}
	.mail_text h2{
		font-size: 16px;
		line-height: 26px;
		color: #000;
		text-align: center;
		margin: 30px 0;
	}
	span{
	    color: #000;
	}
	
	@media (max-width:768px){
		.mail_text{padding: 20px 0;}
	}
</style> 

</head>

<body>
    
<section class="mail_text">
	<div class="container-fluid">
	    <div style="background-color: #000;padding: 10px;display: flex;flex-direction: row-reverse;align-items: center;">
	        <img class="logo" src="{{ asset('site_assets') }}/images/advice_logo.png">
	        <h3 style="font-size: 16px;line-height: 26px;color: #fff;margin-right: 15px;">كي تصبح أفضل</h3>
	   </div>
		<h2>
			 Mail: {!! $email !!}<br>
            Name: {!! $name !!}<br>
            Message: {!! $content !!}
		</h2>
	</div>
</section>

</body>
</html>
