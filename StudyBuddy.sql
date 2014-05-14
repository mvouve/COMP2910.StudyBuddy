

CREATE TABLE User
(
	ID					INTEGER				NOT NULL	AUTO_INCREMENT,
	email				VARCHAR( 96 )		NOT NULL	DEFAULT '',
	displayName			VARCHAR( 32 )		NOT NULL	DEFAULT '',
	password			VARCHAR( 72 )		NOT NULL	DEFAULT '',
	verified			ENUM( 'T','F' )		NOT NULL	DEFAULT 'F',
	deleted				ENUM( 'T','F' )		NOT NULL	DEFAULT 'F',
	verificationString	VARCHAR( 32 )		NOT NULL	DEFAULT '',
	verificationTime	TIMESTAMP			NOT NULL	DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY( ID, email ),
	UNIQUE KEY( email ),
	UNIQUE KEY( verificationString )
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE LoginAttept
(
	email	VARCHAR(96)		NOT NULL,
	time	TIMESTAMP		NOT NULL,
	success	ENUM( 'T','F' )	NOT NULL,
	PRIMARY KEY( email, time )
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE Course
(
    ID      CHAR(8)     NOT NULL,
    name    VARCHAR(80) NOT NULL,
    PRIMARY KEY( ID )
) ENGINE = InnoDB DEFAULT CHARSET = UTF8;

CREATE TABLE UserCourse
(
    userID      INTEGER         NOT NULL,
    courseID    CHAR(8)         NOT NULL,
    visible     enum( 'T','F' ) NOT NULL    DEFAULT 'T',
    PRIMARY KEY( userID, courseID )
) ENGINE = InnoDB DEFAULT CHARSET = UTF8;

CREATE TABLE Meeting
(
	ID			INTEGER			NOT NULL	AUTO_INCREMENT,
	courseID	CHAR(8)			NOT NULL,
	creatorID	INTEGER			NOT NULL,
	comment		VARCHAR(140)	NOT NULL,
	location	VARCHAR(140)	NOT NULL,
	maxBuddys	INTEGER			NOT NULL,
	startDate	DATE			NOT NULL,
	endDate		DATE			NOT NULL,
	PRIMARY KEY( ID )
) ENGINE = InnoDB DEFAULT CHARSET = UTF8;

CREATE TABLE UserMeeting
(
	userID		INTEGER		NOT NULL,
	meetingID	INTEGER		NOT NULL,
	PRIMARY KEY( userID, meetingID )
) ENGINE = InnoDB DEFAULT CHARSET = UTF8;