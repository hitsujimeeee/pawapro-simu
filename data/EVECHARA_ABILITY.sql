CREATE TABLE EVECHARA_ABILITY(
	CHARA_ID VARCHAR(4),
	GET_TYPE INT,
	ABILITY_ID VARCHAR(4),
	PRIMARY KEY(CHARA_ID, GET_TYPE, ABILITY_ID)
);