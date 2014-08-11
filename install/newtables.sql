#Drop table
DROP TABLE IF EXISTS rank;

#Create table
CREATE TABLE rank
(
  period     varchar(30)  COLLATE utf8_bin
, user_id    mediumint(8)
, username   varchar(255) COLLATE utf8_bin
, pos_before mediumint(8)
, pos_now    mediumint(8)
, increase   mediumint(8)
, qtd_before mediumint(8)
, qtd_now    mediumint(8)
);
