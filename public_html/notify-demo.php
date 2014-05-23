<!--Beginning of notify-demo.php-->
        <div data-role="page" data-theme="a" id="page-notify-demo">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Notify Demo' ) ); ?>

            <div data-role="content" data-theme="a">
                <div>
                    <div data-role="form">
                        <form id="notify-demo-form" name="notify-demo-form" method="POST">
                            <label for="notify-demo-message">Message:</label>
                            <input type="text" name="notify-demo-message" id="notify-demo-message" placeholder="message">

                            <a href="#" data-role="button" id="notify-demo-submit" onclick="sendDemoNotification(); return false;">Send Notification</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            function sendDemoNotification()
            {
                $.post( ajaxURL + "notify_demo.php", $( "#notify-demo-form" ).serialize() ).done( function( data ) {
                    alert( "Done!" );
                });
            }
        </script>
<!--End of notify-demo.php-->