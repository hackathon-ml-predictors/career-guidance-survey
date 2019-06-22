<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Career baba | predictors of your career</title>
		<meta name="description" content="Fullscreen Form Interface: A distraction-free form concept with fancy animations" />
		<meta name="keywords" content="fullscreen form, css animations, distraction-free, web design" />
		<meta name="author" content="Codrops" />
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<link rel="stylesheet" type="text/css" href="css/cs-select.css" />
		<link rel="stylesheet" type="text/css" href="css/cs-skin-boxes.css" />
		<script src="js/modernizr.custom.js"></script>
	</head>
	<body>
		<div class="container">

			<div class="fs-form-wrap" id="fs-form-wrap">
				<div class="fs-title">
					<img src="img/logo_transparent.png" width="150" />
					<!-- <div class="codrops-top">
						<a class="codrops-icon codrops-icon-prev" href="http://tympanus.net/Development/NotificationStyles/"><span>Previous Demo</span></a>
					</div> -->
				</div>

				<?php

				if(isset($_GET['q1'])){
					echo "<pre>";
					//print_r($_GET);
					echo "</pre>";
				}
					$handle = curl_init();
					 
					$url = "http://192.168.1.158/hackathon/csvdata/questionresult.php";
					 
					// Set the url
					curl_setopt($handle, CURLOPT_URL, $url);
					// Set the result output to be a string.
					curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
					 
					$output = curl_exec($handle);
					 

					if(curl_error($handle))
					{
						print curl_error($handle);
					}
					else{
						$questions = json_decode($output);
						/*echo "<pre>";
						print_r($questions);
						echo "</pre>";*/
					}
					curl_close($handle);
				?>
				
				<form id="myform" class="fs-form fs-form-full" autocomplete="off">
					<ol class="fs-fields">
						<?php 
							for($index = 0 ; $index<count($questions); $index++) :
							?>
						<?php 
						if($questions[$index]->type == "loader"):
							?>
							<li class="question-loader">
								<label class="fs-field-label fs-anim-upper" for="q<?php echo $index; ?>"><?php echo $questions[$index]->title; ?></label>
								<div class="clearfix loader-img fs-anim-lower">
									<img src="<?php echo $questions[$index]->image; ?>">
								</div>
							</li>
							<?php
						elseif($questions[$index]->type == "question"):
							if($questions[$index]->option_type  == "number") : 
								?>
								<li>
									<label class="fs-field-label fs-anim-upper" for="q<?php echo $index; ?>" data-info="<?php echo $questions[$index]->tooltip; ?>"><?php echo $questions[$index]->title; ?></label>
									<input class="fs-anim-lower" id="q<?php echo $index; ?>" name="q<?php echo $questions[$index]->id; ?>" type="number" placeholder="100" min="0" max="100" required/>
								</li>

							<?php	 
							elseif($questions[$index]->option_type  == "radio"):
							?>
								 <li data-input-trigger>
									<label class="fs-field-label fs-anim-upper" for="q<?php echo $index; ?>" data-info="<?php echo $questions[$index]->tooltip; ?>"><?php echo $questions[$index]->title; ?></label>
									<div class="fs-radio-group fs-radio-custom clearfix fs-anim-lower">
										<?php 
										$opt_index = 0;
										foreach($questions[$index]->options as $option): 
											?>
											<span><input id="q<?php echo $index . $opt_index; ?>" name="q<?php echo $index; ?>" type="radio" value="<?php echo $option; ?>"/><label for="q<?php echo $index . $opt_index; ?>" class="<?php echo str_replace(" ","_",strtolower($option)); ?>" <?php echo ($opt_index=0)?'checked':''?>><?php echo $option; ?></label></span>
											<?php
											$opt_index++;
										endforeach;?>
									</div>
								</li> 
							<?php
							elseif($questions[$index]->option_type  == "checkbox"):
							?>
								<li>
									<label class="fs-field-label fs-anim-upper" for="q<?php echo $index; ?>" data-info="<?php echo $questions[$index]->tooltip; ?>" ><?php echo $questions[$index]->title; ?></label>
									<div class="boxes clearfix fs-anim-lower">
									<?php 
										$opt_index = 0;
										 foreach($questions[$index]->options as $option): 
										?>	
									  		<span><input type="checkbox" id="box-<?php echo $index . $opt_index; ?>" name="q<?php echo $index; ?>[]" value="<?php echo $option; ?>" required>
									  		<label for="box-<?php echo $index . $opt_index; ?>"><?php echo $option; ?></label></span>
									  <?php 
									  	$opt_index++; 
									  	endforeach; 
										?>
									</div>	
								</li> 
							<?php
							endif;
						endif;
						endfor;
						?>						
					</ol><!-- /fs-fields -->
					<button class="fs-submit" id="submit">Send answers</button>
				</form><!-- /fs-form -->
				<div class="fs-form-full" id="thankyou"></div>

			</div>

			<!-- /fs-form-wrap -->

			<!-- Related demos -->
			<!-- <div class="related">
				<p>If you enjoyed this demo you might also like:</p>
				<a href="http://tympanus.net/Development/MinimalForm/">
					<img src="img/relatedposts/minimalform1-300x162.png" />
					<h3>Minimal Form Interface</h3>
				</a>
				<a href="http://tympanus.net/Development/ButtonComponentMorph/">
					<img src="img/relatedposts/MorphingButtons-300x162.png" />
					<h3>Morphing Buttons Concept</h3>
				</a>
			</div> -->

		</div><!-- /container -->
		<script src="js/classie.js"></script>
		<script src="js/selectFx.js"></script>
		<script src="js/fullscreenForm.js"></script>
		<script>
			(function() {
				var formWrap = document.getElementById( 'fs-form-wrap' );

				[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {	
					new SelectFx( el, {
						stickyPlaceholder: false,
						onChange: function(val){
							document.querySelector('span.cs-placeholder').style.backgroundColor = val;
						}
					});
				} );

				new FForm( formWrap, {
					onReview : function() {
						classie.add( document.body, 'overview' ); // for demo purposes only
					}
				} );
			})();
		</script>
	</body>
</html>