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
                    <li><a href="#" 
                           data-icon="star" 
                           data-iconpos="top" 
                           id="i-created">
                        My Creations</a></li>
                    <li><a href="#"
                           data-icon="check"
                           data-iconpos="top"
                           id="i-attending">
                        I'm In!</a></li>
                    <li><a href="#" 
                           data-icon="grid" 
                           data-iconpos="top" 
                           id="not-attending">
                        Not Attending</a></li>
                </ul>
            </div>
                <!--div class="ui-grid-b">
                    <div class="ui-block-a">
                        <label><input type="checkbox"
                                      name="i-created" 
                                      id="i-created"
                                      class="ui-block-a custom-checkbox"/>
                            I Created</label>
                    </div>
                    <div class="ui-block-b">
                        <label><input type="checkbox"
                                      name="i-attending"
                                      id="i-attending"
                                      class="ui-block-b custom-checkbox"/>
                            Iam Attending</label>
                    </div>
                    <div class="ui-block-c">
                        <label><input type="checkbox"
                                      name="not-attending" 
                                      id="not-attending"
                                      class="ui-block-c custom-checkbox"/>
                            I am Not Attending</label>
                    </div>
                </div-->
        </div>
    </div>
<!--End of my-meetings.php-->
