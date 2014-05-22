function colorChange()
{
    var cookieStuff = readCookie('style');
	
    if( cookieStuff != null ){
        if(cookieStuff == "styles1" )
        {
            purpleChange();
        }
        if(cookieStuff == "styles2" )
        {
            greenChange();
        }
        if(cookieStuff == "styles3" )
        {
            darkChange();
        }
        if(cookieStuff == "styles4" )
        {
            cbChange();
        }
    }
    else
    {
        purpleChange();
    }
    
    $( '.green-button' ).on( 'click touchend',greenChange);
    $( '.dark-button' ).on( 'click touchend',darkChange);
    $( '.purple-button' ).on( 'click touchend',purpleChange);
    $( '.cb-button' ).on( 'click touchend', cbChange);
    
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