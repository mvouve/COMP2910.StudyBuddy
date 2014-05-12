<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
    <body>
        <div data-role="page" data-theme="a">
            <?php define('HAS_MENU',1);
                  renderPagelet( 'banner.php', array( '{{title}}' => 'All courses' ) ); ?>
            <div data-role="content">
                <p><label for="all-courses-list">Course search:</label><input type="text" id="search-field"></p>
                <br>
                <ul data-role="listview" id="all-courses-list">
    	            <li data-icon="check"><a href="#">Acura</a></li>
	                <li data-icon="false"><a href="#">Audi</a></li>
	                <li><a href="#">BMW</a></li>
                </ul>
            </div>
            <div data-role="footer">
                <div data-role="navbar">
		            <ul>
			            <li><a href="#">My Courses</a></li>
			            <li><a href="#">Clear All</a></li>
		            </ul>
	            </div>
            </div>
        </div>
    </body>
</html>
