BEGIN
	DECLARE v_mindenok INT;
	DECLARE v_db INT;
	DECLARE v_useremail VARCHAR(150);
	DECLARE v_password VARCHAR(128);
	DECLARE v_id INT;
START TRANSACTION;
	SET v_mindenok = 1;
	SET p_message = '.';
	SELECT COUNT(user_email) INTO v_db FROM users WHERE user_email = p_email;
	IF(v_db = 1) THEN
		
		SELECT user_id, user_email, user_pw INTO v_id, v_useremail, v_password FROM users WHERE user_email = p_email;
		IF(v_password = p_pw) THEN
			INSERT INTO logs (user_id, log_content, log_date) VALUES(v_id, 'SUCCESSFUL Login. ', NOW());
		ELSE
			SET v_mindenok = 0;
			SET p_message = CONCAT(p_message, 'Incorrect password! ');
		END IF;
	ELSE
		SET v_mindenok = 0;
		SET p_message = CONCAT(p_message, 'Login failed! ');
	END IF;
	
	IF(v_mindenok = 1) THEN
		SET p_message = 'ok';
		COMMIT;
	ELSE
		ROLLBACK;
	END IF;
END;