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
            <!--CALVINS BEAUTIFUL CREATION-->
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
            <!-- CHECKBOX ATTEMPT ONE -->
            <div class="ui-grid-b" class="center">
                <div class=" ui-block-a custom-checkbox" >
                    <label class="custom-checkbox">
                        <input type="checkbox"
                               name="i-created"
                               id="i-created"/>
                        I have Created     </label>
                </div>
                <div class="ui-block-b" class="center">
                    <label class="custom-checkbox">
                        <input type="checkbox"
                               name="i-attending"
                               id="i-attending"/>
                        I am Attending     </label>
                </div>
                <div class="ui-block-c" class="center">
                    <label class="custom-checkbox">
                        <input type="checkbox"
                               name="not-attending"
                               id="not-attending"/>
                        I am Not Attending</label>
                </div>
            </div>
            <!-- CHECKBOX ATTEMPT 2-->
            <div class="ui-field-contain" class="center" class="custom-checkbox">
                <fieldset data-role="controlgroup" data-type="horizontal" >
                    <label class="custom-checkbox checkbox-threeway">
                        <input type="checkbox"
                               name="i-created"
                               id="i-created"/>
                        I have Created     </label>
                    <label class="custom-checkbox checkbox-threeway">
                        <input type="checkbox"
                               name="i-attending"
                               id="i-attending"/>
                        I am Attending     </label>
                    <label class="custom-checkbox checkbox-threeway">
                        <input type="checkbox"
                               name="not-attending"
                               id="not-attending"/>
                        I am Not Attending</label>
                </fieldset>
            </div>
            <!-- END -->
        </div>
    </div>
<!--End of my-meetings.php-->
