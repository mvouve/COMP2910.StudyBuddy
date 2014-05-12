CREATE TABLE Course
(
    ID      CHAR(8)     NOT NULL,
    name    VARCHAR(20) NOT NULL,
    PRIMARY KEY( ID )
) ENGINE = InnoDB DEFAULT CHARSET = UTF8;

CREATE TABLE UserCourse
(
    userID      INTEGER         NOT NULL,
    courseID    CHAR(8)         NOT NULL,
    visable     enum( 'T','F' ) NOT NULL    DEFAULT 'T',
    PRIMARY KEY( userID, courseID )
) ENGINE = InnoDB DEFAULT CHARSET = UTF8;