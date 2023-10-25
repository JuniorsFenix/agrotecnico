<?php
/****************************************************************/
/*
/* Html
/*
/****************************************************************/

//Action Web Head
add_action('ux_interface_webhead', 'ux_interface_webhead_viewport', 10);
add_action('ux_interface_webhead', 'ux_interface_webhead_favicon', 15);


/****************************************************************/
/*
/* Mobile
/*
/****************************************************************/

//Action Hook Mobile meta
add_action('ux_interface_mobile', 'ux_interface_mobilemeta', 10);

//Action Hook Mobile social
add_action('ux_interface_mobile_social', 'ux_interface_social', 10);


/****************************************************************/
/*
/* Header
/*
/****************************************************************/

//Action Hook Header
add_action('ux_interface_header', 'ux_interface_header', 10);


/****************************************************************/
/*
/* Sidebar
/*
/****************************************************************/

//Action Hook Sidebar
add_action('ux_interface_sidebar', 'ux_interface_sidebar', 10);

//Action Hook Sidebar social
add_action('ux_interface_sidebar_social', 'ux_interface_social', 10);

//Action Hook Sidebar logo
add_action('ux_interface_sidebar_logo', 'ux_interface_logo', 10);

//Action Hook Sidebar Widget
add_action('ux_interface_sidebar_widget', 'ux_interface_sidebar_widget', 10);


/****************************************************************/
/*
/* Archive
/*
/****************************************************************/

//Action Hook Archive Loop
add_action('ux_interface_archive_loop', 'ux_interface_archive_loop', 10);


/****************************************************************/
/*
/* Titlebar
/*
/****************************************************************/


//Action Hook Title bar
add_action('ux_interface_title_bar', 'ux_interface_title_bar', 10);


/****************************************************************/
/*
/* Page
/*
/****************************************************************/

//Action Hook Page Content
add_action('ux_interface_page_content', 'ux_interface_page_portfolio', 10);
add_action('ux_interface_page_content', 'ux_interface_page_featured_image', 10);
add_action('ux_interface_page_content', 'ux_interface_page_enable_slider', 10);
add_action('ux_interface_page_content', 'ux_interface_page_title_bar', 15);
add_action('ux_interface_page_content', 'ux_interface_pagebuilder', 20);
add_action('ux_interface_page_content', 'ux_interface_page_content', 25);

//Action Hook Page Before
add_action('ux_interface_page_before', 'ux_interface_page_before', 10);

//Action Hook Page After
add_action('ux_interface_page_after', 'ux_interface_page_after', 10);


/****************************************************************/
/*
/* Single
/*
/****************************************************************/

//Action Hook Single Content
add_action('ux_interface_single_content', 'ux_interface_single_portfolio', 10);
add_action('ux_interface_single_content', 'ux_interface_page_title_bar', 15);
add_action('ux_interface_single_content', 'ux_interface_pagebuilder', 20);
add_action('ux_interface_single_content', 'ux_interface_single_content', 25);
add_action('ux_interface_single_content', 'ux_interface_single_comment', 30);

//Action Hook Single Before
add_action('ux_interface_single_before', 'ux_interface_top_image', 5);
add_action('ux_interface_single_before', 'ux_interface_page_before', 10);

//Action Hook Single After
add_action('ux_interface_single_after', 'ux_interface_page_after', 10);

//Action Hook Single summary
add_action('ux_interface_single_summary', 'ux_interface_single_format_video', 10);


/****************************************************************/
/*
/* home
/*
/****************************************************************/

//Action Hook Site Loading
add_action('ux_interface_site_loading', 'ux_interface_site_loading', 10);

/****************************************************************/
/*
/* post and page loading
/*
/****************************************************************/

//Action Hook Post/Page Loading
add_action('ux_interface_site_loading', 'ux_interface_page_loading', 15);


?>