function colorChange()
{
    var cookieStuff = readCookie('style');
    if(cookieStuff != null){
        if(cookieStuff.match("css/study-buddy-theme-5.min.css"))
        {
            purpleChange();
        }
        if(cookieStuff.match("css/StudyBuddyV2.css"))
        {
            greenChange();
        }
        if(cookieStuff.match("css/NightTheme.css"))
        {
            darkChange();
        }
        if(cookieStuff.match("css/ColorBlindOption.css"))
        {
            cbChange();
        }
    }
    
    $( '.green-button' ).on( 'click tap',greenChange);
    $( '.dark-button' ).on( 'click tap',darkChange);
    $( '.purple-button' ).on( 'click tap',purpleChange);
    $( '.cb-button' ).on( 'click tap', cbChange);
    
    function greenChange(){
        $( '.ui-navbar' ).removeClass( 'black-ui-navbar' ).removeClass('purple-ui-navbar').removeClass('cb-ui-navbar').addClass( 'green-ui-navbar' );
        $( '.listview-wrapper form' ).removeClass( 'black-listview-wrapper' ).removeClass( 'purple-listview-wrapper' ).removeClass( 'cb-listview-wrapper' ).addClass( 'green-listview-wrapper' );
    }
    function darkChange(){
        $( '.ui-navbar' ).removeClass( 'green-ui-navbar' ).removeClass('purple-ui-navbar').removeClass('cb-ui-navbar').addClass( 'black-ui-navbar' );
        $( '.listview-wrapper form' ).removeClass( 'green-listview-wrapper' ).removeClass( 'purple-listview-wrapper' ).removeClass( 'cb-listview-wrapper' ).addClass( 'black-listview-wrapper' );
    }
    function purpleChange(){
        $( '.ui-navbar' ).removeClass( 'green-ui-navbar' ).removeClass( 'black-ui-navbar' ).removeClass('cb-ui-navbar').addClass( 'purple-ui-navbar' );
        $( '.listview-wrapper form' ).removeClass( 'black-listview-wrapper' ).removeClass( 'green-listview-wrapper' ).removeClass( 'cb-listview-wrapper' ).addClass( 'purple-listview-wrapper' );
    }
    function cbChange(){
        $( '.ui-navbar' ).removeClass( 'green-ui-navbar' ).removeClass( 'black-ui-navbar' ).removeClass( 'purple-ui-navbar' ).addClass('cb-ui-navbar');
        $( '.listview-wrapper form' ).removeClass( 'black-listview-wrapper' ).removeClass( 'green-listview-wrapper' ).removeClass( 'purple-listview-wrapper' ).addClass( 'cb-listview-wrapper' );
    }
}