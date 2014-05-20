ALTER TABLE Meeting
    ADD canceled    enum('T', 'F' ) NOT NULL    DEFAULT 'F';
    
CREATE INDEX meeting_end_date ON Meeting (endDate);