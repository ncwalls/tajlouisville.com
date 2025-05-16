<?php get_header(); ?>

	<?php while( have_posts() ): the_post(); ?>
		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			
			<?php if($hero = get_field('hero')): ?>
				<div class="hero">

					<img class="hero-logo" src="<?php the_field( 'default_logo', 'option' ); ?>" alt="<?php bloginfo( 'name' ); ?>">

					<?php
						$hero_type = $hero['type'];
						
						// $popup_video_type = $hero['popup_type'];
						// $popup_video_embed_url = $hero['popup_video_embed'];
						// $popup_video_file = $hero['popup_video_file'];
						// $popup_video_url = false;
						// $popup_video_action = '';
					?>

					<div class="hero-bg"></div>
					
					<?php if($hero_type == 'image' && $hero['image']): ?>
						<div class="hero-img" style="background-image:url(<?php echo $hero['image']['url']; ?>)"></div>

					<?php elseif($hero_type == 'slider' && $hero['slider']): ?>
						<div class="hero-slider">
							<?php foreach($hero['slider'] as $slide): ?>
								<div class="slide">
									<div class="img" style="background-image:url(<?php echo $slide['image']['url']; ?>)"></div>
								</div>
							<?php endforeach; ?>
						</div>

					<?php elseif($hero_type == 'video_file' && $hero['video_file']): ?>
						<div class="hero-video">
							<?php $video_url = $hero['video_file']['url']; ?>
							<video src="<?php echo $video_url; ?>" poster="<?php //echo $hero_bg; ?>" autoplay muted loop playsinline ></video>
						</div>

					<?php elseif($hero_type == 'video_embed' && $hero['video_embed']): ?>
						<?php 
							$video = $hero['video_embed'];

							// Add autoplay functionality to the video code
							if ( preg_match('/src="(.+?)"/', $video, $matches) ) {
								// Video source URL
								$src = $matches[1];

								// get youtube video id
								preg_match('/embed\/(.*?)\?/', $src, $vid_id_arr);
								
								if(is_array($vid_id_arr) && count($vid_id_arr) > 0){
									if(isset($vid_id_arr[1])){
										$playlist_id = $vid_id_arr[1];
									}
									else{
										$playlist_id = $vid_id_arr[0];
									}
								}
								else{
									$playlist_id = '';
								}

								// Add option to hide controls, enable HD, and do autoplay -- depending on provider
								$params = array(
									'controls'    => 0,
					                'muted' => 1,
					                'mute' => 1,
					                'playsinline' => 1,
									'hd'  => 1,
									'background' => 1,
									'loop' => 1,
									'title' => 0,
									'byline' => 0,
									'autoplay' => 1,
					                'playlist' => $playlist_id // required to loop youtube
								);

								
								$new_src = add_query_arg($params, $src);
								
								$video = str_replace($src, $new_src, $video);
								
								// add extra attributes to iframe html
								$attributes = 'frameborder="0" autoplay muted loop playsinline webkit-playsinline allow="autoplay; fullscreen"';
								 
								$video = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $video);
							}
						?>
						<div class="hero-video"><?php echo $video ?></div>

					<?php endif; ?>

					<div class="hero-content">
						<?php if($hero['title']): ?>
							<h1 class="hero-title"><?php echo $hero['title']; ?></h1>
						<?php endif; ?>
						<?php /*if($popup_video_type == 'file' && $popup_video_file): ?>
							<a href="#hero-video-modal-container" class="hero-play no-scroll" data-action="hero-popup-play">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 50.8 50.8" style="enable-background:new 0 0 50.8 50.8;" xml:space="preserve">
									<path d="M35.9,26.5l-8,4.6l-8,4.6c-1.1,0.6-1.9,0.1-1.9-1.1v-9.2v-9.2c0-1.2,0.9-1.7,1.9-1.1l8,4.6l8,4.6C37,24.9,37,25.9,35.9,26.5
											 M25.4,0C11.4,0,0,11.4,0,25.4c0,14,11.4,25.4,25.4,25.4c14,0,25.4-11.4,25.4-25.4C50.8,11.4,39.5,0,25.4,0"/>
								</svg>
								<span>Play Full Video</span>
							</a>
						<?php elseif($popup_video_type == 'embed' && $popup_video_embed_url): ?>
							<a href="<?php echo $popup_video_embed_url; ?>" class="hero-play no-scroll" data-action="hero-popup-embed">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 50.8 50.8" style="enable-background:new 0 0 50.8 50.8;" xml:space="preserve">
									<path d="M35.9,26.5l-8,4.6l-8,4.6c-1.1,0.6-1.9,0.1-1.9-1.1v-9.2v-9.2c0-1.2,0.9-1.7,1.9-1.1l8,4.6l8,4.6C37,24.9,37,25.9,35.9,26.5
									 M25.4,0C11.4,0,0,11.4,0,25.4c0,14,11.4,25.4,25.4,25.4c14,0,25.4-11.4,25.4-25.4C50.8,11.4,39.5,0,25.4,0"/>
								</svg>
								<span>Play Full Video</span>
							</a>
						<?php endif;*/ ?>
					</div>
				</div>

				<?php /*if($popup_video_type == 'file' && $popup_video_file): ?>
					<div class="video-outer-wrap" id="hero-video-modal-container">
						<div class="video-container">
							<?php if($popup_video_type == 'file' && $popup_video_file): ?>
								<video id="hero-video-modal" src="<?php echo $popup_video_file['url']; ?>" poster="<?php ?>" playsinline controls ></video>
							<?php endif; ?>
						</div>
					</div>
				<?php endif;*/ ?>
			<?php endif; ?>

			<section class="home-section home-intro">
				<div class="container">
					<div class="content">
						<?php if(get_field('intro_title')): ?>
							<h2 class="section-title"><?php the_field('intro_title'); ?></h2>
						<?php endif; ?>
						<div class="subtitles">
							<?php if(get_field('intro_subtitle_1')): ?>
								<h3 class="section-subtitle subtitle-1"><?php the_field('intro_subtitle_1'); ?></h2>
							<?php endif; ?>
							<?php if(get_field('intro_subtitle_2')): ?>
								<h3 class="section-subtitle subtitle-2"><?php the_field('intro_subtitle_2'); ?></h2>
							<?php endif; ?>
						</div>
					</div>
					<?php if($intro_gallery = get_field('intro_gallery')): ?>
						<ul class="gallery home-gallery">
							<?php foreach($intro_gallery as $img): ?>
								<li>
									<a href="<?php echo $img['url']; ?>"><img src="<?php echo $img['sizes']['small']; ?>" alt=""></a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</section>

			<section class="home-section home-events">
				<div class="container">
					<?php if(get_field('events_title')): ?>
						<h2 class="section-title"><?php the_field('events_title'); ?></h2>
					<?php endif; ?>
					<?php
						$recent_events = get_posts(array(
							'post_type' => 'msw_events',
							'orderby' => 'meta_value',
							'meta_key' => 'start_date',
							'order' => 'ASC',
							'posts_per_page' => 2,
							'fields' => 'ids',
							'meta_query' => array(
								array(
									'key' => 'start_date',
									'value' => date('Ymd'),
									'compare' => '>=',
								)
							)
						));
					?>
					<?php if($recent_events): ?>
						<ul class="events">
							<?php foreach ($recent_events as $event_id): ?>
								<li class="event">
									<?php
										$thumb_image = '';
										if( get_the_post_thumbnail_url($event_id) ){
											$thumb_image = get_the_post_thumbnail_url( $event_id, 'medium' );
										}
										else{
											$thumb_image = get_field( 'default_placeholder_image', 'option' )['sizes']['medium'];
										}
									?>
									<figure class="image">
										<img src="<?php echo $thumb_image; ?>" alt="" loading="lazy">
									</figure>
									<div class="content">
										<h3 class="title"><?php echo get_the_title($event_id); ?></h3>
										<p class="event-date">
											<?php
												$start_date = get_field('start_date', $event_id);

												if(get_field('end_date', $event_id)){
													$end_date = get_field('end_date', $event_id);
												}
												else{
													$end_date = $start_date;
												}

												$start_date_obj = date_create($start_date);
												$start_date_display = date_format($start_date_obj,"F j, Y");
												
												if($end_date == $start_date){
													echo $start_date_display;
												}
												else{
													$start_year = date_format($start_date_obj,"Y");
													$start_month = date_format($start_date_obj,"m");
												
													$end_date_obj = date_create($end_date);
													$end_date_display = date_format($end_date_obj,"F j, Y");
													
													$end_year = date_format($end_date_obj,"Y");
													$end_month = date_format($end_date_obj,"m");

													if($start_year == $end_year){
														$start_date_display = date_format($start_date_obj,"F j");
													}


													echo $start_date_display;
													echo ' - <span>' . $end_date_display . '</span>';
												}
											?>
										</p>
										<p class="event-time">
											<?php
												$start_time = get_field('start_time', $event_id);
												$start_time_date = date_create($start_time);
												$start_time_display = date_format($start_time_date, 'g:ia');

												$end_time = get_field('end_time', $event_id);
												$end_time_date = date_create($end_time);
												$end_time_display = date_format($end_time_date, 'g:ia');

												echo $start_time_display . ' - ' . $end_time_display;
											?>
										</p>
										<?php if(get_field('details', $event_id)): ?>
											<p class="details">
												<?php the_field('details', $event_id); ?>
											</p>
										<?php endif; ?>

										<?php /*<a href="">Get the deets</a>*/ ?>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</section>

		</article>
	<?php endwhile; ?>
<?php get_footer();