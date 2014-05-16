function colorChange()
{
    $( '.green-button' ).on( 'click tap',function (e){
        $( '.ui-navbar' ).removeClass( 'black-ui-navbar' ).addClass( 'green-ui-navbar' );
        $( '.ui-listviewwrap form' ).remove( 'black-listview-wrapper' ).addClass( 'green-listview-wrapper' );
    });

    $( '.dark-button' ).on( 'click tap',function (e){
        $( '.ui-navbar' ).removeClass( 'green-ui-navbar' ).addClass( 'black-ui-navbar' );
        $( '.ui-listviewwrap form' ).remove( 'green-listview-wrapper' ).addClass( 'black-listview-wrapper' );
        
    });

    $( '.purple-button' ).on( 'click tap',function (e){
        $( '.ui-navbar' ).removeClass( 'green-ui-navbar' ).removeClass( 'black-ui-navbar' );
        $( '.ui-listviewwrap form' ).remove( 'black-listview-wrapper' ).removeClass( 'green-listview-wrapper' );
    });
}