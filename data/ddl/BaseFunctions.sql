CREATE FUNCTION wbf_access_level(  ) RETURNS integer AS $$
DECLARE
    access_level integer := 0;
BEGIN

    quantity := 50;
    --
    -- Create a subblock
    --
    DECLARE
        quantity integer := 80;
    BEGIN
        RAISE NOTICE 'Quantity here is %', quantity;  -- Prints 80
        RAISE NOTICE 'Outer quantity here is %', outerblock.quantity;  -- Prints 50
    END;


    RETURN access_level;
END;
$$ LANGUAGE plpgsql;