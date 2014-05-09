
			<div data-role="header">
				<a href='index.php' rel='external' id='logo-btn' data-inline='true' class="ui-btn-left" ><img src="images/sb-logo.png" alt="Study Buddy"/></a>
                <h1>{{title}}</h1>
                <?php
                    if( defined('HAS_MENU') )
                        echo "<a href='#menuPanel' data-role='button' data-inline='true' data-icon='bars' class='ui-btn-right' data-position='right' data-display='overlay'>Menu</a>";
                ?>
			</div>
            <?php
                if( defined('HAS_MENU') )
                    renderPagelet( 'menu.php', array() );
            ?>
