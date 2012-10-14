
CREATE FUNCTION test() RETURNS integer AS '
DECLARE
    -- Deklarationen
BEGIN
    PERFORM meine_funktion();
END;
' LANGUAGE plpgsql;