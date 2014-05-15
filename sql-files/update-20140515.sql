-- 0 = none 1 = created 2 = created 4 = courses
ALTER TABLE User 
	ADD meetingVisablity	SMALLINT	NOT NULL	DEFAULT 7;
