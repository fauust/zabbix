delimiter $
CREATE PROCEDURE zbx_drop_indexes()
BEGIN
	DECLARE dummy INT DEFAULT 0;
	DECLARE CONTINUE HANDLER FOR SQLSTATE '42000' set dummy = 1;

	DROP INDEX node_cksum_233 on node_cksum;
	DROP INDEX node_cksum_2 on node_cksum;
	DROP INDEX node_cksum_3 on node_cksum;
	DROP INDEX node_cksum_344 on node_cksum;
END$
delimiter ;

CALL zbx_drop_indexes();
DROP PROCEDURE zbx_drop_indexes;

ALTER TABLE node_cksum MODIFY nodeid integer NOT NULL,
		       MODIFY recordid bigint unsigned NOT NULL;
DELETE FROM node_cksum WHERE NOT nodeid IN (SELECT nodeid FROM nodes);
CREATE INDEX node_cksum_1 ON node_cksum (nodeid,cksumtype,tablename,recordid);
ALTER TABLE node_cksum ADD CONSTRAINT c_node_cksum_1 FOREIGN KEY (nodeid) REFERENCES nodes (nodeid) ON DELETE CASCADE;
