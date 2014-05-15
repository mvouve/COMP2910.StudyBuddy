
			<div data-role="header" data-position="fixed" data-disable-page-zoom="true" data-tap-toggle="false" data-tap-toggle-blacklist="input">
				<a href='index.php' rel='external' id='logo-btn' data-inline='true' class="ui-btn-left" ><img src="images/sb-logo.png" alt="Study Buddy"/></a>
                <h1>{{title}}</h1>
                <?php
                    if( defined('HAS_MENU') )
                        echo "<a href='#' class='menu-toggle' data-role='button' data-inline='true' data-icon='bars' class='ui-btn-right' data-position='right' data-display='overlay'>Menu</a>";
                ?>
			</div>
            <?php
                if( defined('HAS_MENU') )
                    renderPagelet( 'menu.php', array() );
            ?>
