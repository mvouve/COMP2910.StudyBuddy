<?php
include_once( '../public_html/config.php' );
include_once( 'common.php' );
include_once( 'class-meeting.php' );
global $db;

$meeting = new Meeting();

echo( $meeting->createMeeting( 'COMP1510', 
                     2, 
                     'studyUP!', 
                     'ehpod', 
                      10, 
                     '2014-06-16 22:08:17', 
                     '2014-06-16 22:10:17'
                    ) );    
echo( '<br>' );
$sql = 'SELECT MAX( ID ) AS max
            FROM meeting;';
$sql = $db->prepare( $sql );
$sql->execute();
$max = $sql->fetch( PDO::FETCH_ASSOC );
$max = $max['max'];
echo( 'max ' . $max . '<br>' );
echo( $meeting->joinMeeting( $max, 1  ) );
echo( '<br>' );
echo( 'Meeting Master Check ' . $meeting->isMaster( 1, 60 ) );
print_r( $meeting->getMeetingDetails( 60 ) );