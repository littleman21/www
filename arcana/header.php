<?php
	function headers($current_page=''){
		echo '
			<!-- Header -->
				<div id="header">

					<!-- Logo -->
						<h1><a href="index.php" id="logo">Welcome To ChangChun</a></h1>

					<!-- Nav -->
						<nav id="nav">';
							
		$header_menu = array (
			'Home'=>'index.php',
			'English Course'=> array(
					'english.php',
					array(
						'English Intergrated'=>'engl_int.php',
						'English Conversation'=>'eng_conv.php',
						'English Writing'=>'eng_writ.php',
					),
				),
			'Computer Course'=> array(
					'computer.php',
					array(
						'Basic Computer'=>'computer_basic.php',
						'Intermediate Computer'=>'computer_int.php',
						'Basic Excel'=>'excel_basic.php',
						'Advanced Excel'=>'excel_adv.php',
					),
				),
			'Floral Course'=> array(
					'floral_courses.php',
					array(
						'Floral Beginer'=>'floral_begin.php',
						'Floral Intermediate'=>'floral_inter.php',
						'Floral Advanced'=>'floral_adv.php',
					),
				),				
			'Floral Society'=>'floral_society.php',
			//'College'=>'college.php',
			//'FAQ'=>'faq.php',
			'Contact'=>'contact.php'
		);
		
		
		function show_header($menu, $current_page_in=''){
			echo '<ul>';
			foreach( $menu as $name => $link ){
				if ($name == $current_page_in ) $current=' class="current"'; else $current='';
				if (is_array($link)){
					echo '<li'.$current.'>';
					echo '<a href="'.$link[0].'">'.$name.'</a>';
					show_header($link[1]);
					echo '</li>';
					continue;
				}				
				echo '<li'.$current.'><a href="'.$link.'">'.$name.'</a></li>';
			}
			echo '</ul>';
		}

		show_header($header_menu, $current_page);
		
/* 								<li ><a href="index.php">Home</a></li>
								<li>
									<a href="#">Courses</a>
									<ul>
										<li ><a href="#">English</a></li>
										<li><a href="#">Computer</a></li>
										<li class="current"><a href="#">Floral</a></li>
										<li><a href="#">FAQ</a></li>
									</ul>
								</li>
								<li><a href="left-sidebar.php">Floral Society</a></li>
								<li><a href="right-sidebar.html">College</a></li>
								<li><a href="two-sidebar.html">Organization</a></li>
								<li><a href="no-sidebar.html">Contact</a></li>
							</ul> */
		echo '</nav>
		</div>';

	}
?>