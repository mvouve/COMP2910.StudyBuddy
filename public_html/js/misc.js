function colorChange()
{
    $( '#green-button' ).on( 'click tap',function (e){
        $( '.ui-navbar' ).remove( 'black-ui-navbar' ).addClass( 'green-ui-navbar' );
    });

    $( '#dark-button' ).on( 'click tap',function (e){
        $( '.ui-navbar' ).remove( 'green-ui-navbar' ).addClass( 'black-ui-navbar' );
    });

    $( '#purple-button' ).on( 'click tap',function (e){
        $( '.ui-navbar' ).remove( 'green-ui-navbar' ).removeClass( 'black-ui-navbar' );
    });
}