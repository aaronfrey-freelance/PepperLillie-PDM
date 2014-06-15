<?php

// If page is in category About or Projects
if(in_category(3) || in_category(4)) {
	// Display custom sidebar
	get_sidebar('category');
} else {
	dynamic_sidebar('sidebar-primary');
}