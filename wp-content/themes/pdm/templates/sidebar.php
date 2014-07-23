<?php

// If page is in category About or Projects
if(in_category(3) || in_category(4)) {
	// Display custom category sidebar
	get_sidebar('category');
} else if (is_page(10)) {
	// Display custom contact page sidebar
	get_sidebar('contact');
}
// If is Careers landing or Single Career listing or News index page
else if(onJobs() || is_category(7)) {
	get_sidebar('careers');
} else {
	dynamic_sidebar('sidebar-primary');
}