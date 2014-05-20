<!--Beginning of my-meetings.php-->
    <div data-role="page" data-theme="a" id='page-my-meetings'>
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
                    <li><a href="#" id="create-meeting-button" data-icon="plus" data-iconpos="top">Create Meeting</a></li>
                    <li><a href="#" id="cancel-meeting-button" data-icon="plus" data-iconpos="top">Cancel my meeting</a></li>
                    <li><a href="#" id="all-meetings-button" data-icon="plus" data-iconpos="top">All meetings</a></li>
                    <li><a href="#" id="attending-meetings-button" data-icon="plus" data-iconpos="top">Meetings I'm Attending</a></li>
                </ul>
            </div>
        </div>
    </div>
    <script>
        //
    </script>
<!--End of my-meetings.php-->
                        
            