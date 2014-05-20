<!--Beginning of my-meetings.php-->
    <div data-role="page" data-theme="a" id="page-my-meetings">
        <?php renderPagelet( 'banner.php', array( '{{title}}' => 'My Meetings') ); ?>
        <form id="get-my-meetings-form" name="get-my-meetings-form" method="POST">
            <input type="hidden" name="method" value="get-meetings" />
        </form>        
        <div data-role="content" class="listview-wrapper">
            <ul data-role="listview" data-filter="true" id="my-meetings-list">
            </ul>
        </div>
        <div data-role="footer" data-position="fixed" data-tap-toggle="false">
            <div data-role="navbar">
                <ul>
                    <li><a href="#" data-icon="star" data-iconpos="top" id="i-created">My Creations</a></li>
                    <li><a href="#" data-icon="check" data-iconpos="top" id="i-attending">I'm In!</a></li>
                    <li><a href="#" data-icon="grid" data-iconpos="top" id="not-attending">Not Attending</a></li>
                </ul>
            </div>
        </div>
    </div>
<!--End of my-meetings.php-->
