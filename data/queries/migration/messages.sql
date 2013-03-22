set search_path = production;

-- version 1 to actual
update wbfsys_message_receiver set vid = id_receiver where NOT vid is null AND NOT id_receiver is null;
UPDATE wbfsys_message_receiver set id_receiver = null;

-- version 2 to actual
INSERT INTO wbfsys_message_receiver
    SELECT 
      id_message, 
      vid,
      flag_deleted,
      m_time_created,
      m_role_create
    FROM (
      SELECT 
        rowid as id_message, 
        id_receiver as vid,
        flag_receiver_deleted as flag_deleted,
        m_time_created,
        m_role_create 
      FROM wbfsys_message
        WHERE NOT id_receiver is null
    )
    AS t(
      id_message bigint, 
      vid bigint,
      flag_deleted boolean,
      m_time_created date,
      m_role_create bigint
    );

UPDATE wbfsys_message set id_receiver = null;

-- create aspects

INSERT INTO wbfsys_message_aspect
    SELECT 
      aspect, 
      id_receiver,
      id_message
    FROM (
      SELECT 
        1::smallint as aspect, 
        id_sender as id_receiver,
        rowid as id_message
      FROM wbfsys_message
    )
    AS t(
      aspect smallint, 
      id_receiver bigint,
      id_message bigint
    );

INSERT INTO wbfsys_message_aspect
    SELECT 
      aspect, 
      id_receiver,
      id_message
    FROM (
      SELECT 
        1::smallint as aspect, 
        vid as id_receiver,
        id_message as id_message
      FROM wbfsys_message_receiver
    )
    AS t(
      aspect smallint, 
      id_receiver bigint,
      id_message bigint
    );
