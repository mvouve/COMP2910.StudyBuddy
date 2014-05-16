function colorChange()
{
    $( '.green-button' ).on( 'click tap',function (e){
        $( '.ui-navbar' ).removeClass( 'black-ui-navbar' ).removeClass('purple-ui-navbar').removeClass('cb-ui-navbar').addClass( 'green-ui-navbar' );
        $( '.listview-wrapper form' ).removeClass( 'black-listview-wrapper' ).removeClass( 'purple-listview-wrapper' ).removeClass('cb-listview-        wrapper').addClass( 'green-listview-wrapper' );
    });

    $( '.dark-button' ).on( 'click tap',function (e){
        $( '.ui-navbar' ).removeClass( 'green-ui-navbar' ).removeClass('purple-ui-navbar').removeClass('cb-ui-navbar').addClass( 'black-ui-navbar' );
        $( '.listview-wrapper form' ).removeClass( 'green-listview-wrapper' ).removeClass( 'purple-listview-wrapper' ).removeClass('cb-listview-wrapper').addClass( 'black-listview-wrapper' );
        
    });

    $( '.purple-button' ).on( 'click tap',function (e){
        $( '.ui-navbar' ).removeClass( 'green-ui-navbar' ).removeClass( 'black-ui-navbar' ).removeClass('cb-ui-navbar').addClass( 'purple-ui-navbar' );
        $( '.listview-wrapper form' ).removeClass( 'black-listview-wrapper' ).removeClass( 'green-listview-wrapper' ).removeClass('cb-listview-wrapper').addClass( 'purple-listview-wrapper' );
    });
    
    $( '.cb-button' ).on( 'click tap',function (e){
        $( '.ui-navbar' ).removeClass( 'green-ui-navbar' ).removeClass( 'black-ui-navbar' ).removeClass( 'purple-ui-navbar' ).addClass('cb-ui-navbar');
        $( '.listview-wrapper form' ).removeClass( 'black-listview-wrapper' ).removeClass( 'green-listview-wrapper' ).removeClass( 'purple-listview-wrapper' ).addClass( 'cb-listview-wrapper' );
    });    
}