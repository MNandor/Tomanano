BEGIN
	DECLARE v_mindenok INT DEFAULT 1;
	DECLARE v_email VARCHAR(150);
	DECLARE v_id INT DEFAULT 0;
START TRANSACTION;
	SET p_message = 'ok';
	IF(LENGTH(p_email)>150 OR LENGTH(p_fullname)>150 OR LENGTH(p_email)<1 OR LENGTH(p_fullname)<1 OR LENGTH(p_pw)<1 OR LENGTH(p_pw)>128) THEN
		SET v_mindenok = 0;
		SET p_message = CONCAT(p_message, ' Length of email and fullname must be between 1-150! ');
	END IF;
	SELECT COUNT(user_email) INTO v_email FROM users WHERE user_email = p_email;
	IF(v_email > 0) THEN
		SET v_mindenok = 0;
		SET p_message = CONCAT(p_message, ' There have been already a registration with this email! ');
	END IF;
	
	IF(v_mindenok = 1) THEN
		INSERT INTO users (user_name, user_email, user_pw) VALUES(p_fullname, p_email, p_pw);
		SELECT user_id INTO v_id FROM users WHERE user_email = p_email;
		IF(v_id > 0) THEN
			INSERT INTO logs (user_id, log_content, log_date) VALUES(v_id, 'SUCCESSFUL Registration. ', NOW());
		ELSE
			SET v_mindenok = 0;
			SET p_message = CONCAT(p_message, ' An error occured with the user ID! ');
		END IF;
	END IF;
	
	IF(v_mindenok = 1) THEN
		COMMIT;
	ELSE
		ROLLBACK;
	END IF;
END;