<?php
include_once( '../public_html/config.php' );
include_once( 'common.php' );
include_once( 'class-meeting.php' );

$meeting = new Meeting();

echo( $meeting->createMeeting( 'COMP1510', 
                     0, 
                     'studyUP!', 
                     'ehpod', 
                      10, 
                     '2014-06-16 22:08:17', 
                     '2014-06-16 22:10:17'
                    ) );    
echo( '<br>' );
$foo = $meeting->getMeetingList( 0 );

echo( count( $foo ) );
for( $i = 0; $i < count( $foo ); $i++ )
{
    print_r( $foo[$i] );
}