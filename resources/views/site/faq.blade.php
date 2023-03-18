@extends('site.layouts.app')
@section('content')
<section class="single_service">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="serv_name">
					<h3>الأسئلة الشائعة</h3>

					<ul id="accordion" class="accordion">
					    @foreach($faqs as $faq)
					    
                	<li class="default open">
                    	<div class="link">{{$faq->question}}
                    		<i class="fas fa-plus"></i>
                    	</div>
	                    <div class="row">
	                        <p>
	                        	{{$faq->answer}}
	                        </p>
	                    </div><!-- row -->
                	</li>
                    @endforeach
	                
	            </ul>

				</div>
			</div>
		</div>
	</div>
</section>
@endsection
<!--<script src="js/jquery-3.2.0.js"></script>-->
<!--<script src="js/bootstrap.min.js"></script>-->
<!--<script src="js/owl.carousel.min.js"></script>-->
<!--<script src="js/wow.min.js"></script>-->
<!--<script src="js/jquery.nicescroll.min.js"></script>-->
<!--<script src="js/animate-number.js"></script>-->
<!--<script src="js/script.js"></script>-->

