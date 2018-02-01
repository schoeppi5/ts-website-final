<?php
		/*General Information*/
		$config["general"]["title"] 			= "Suchtclub.de";
		$config["general"]["heading"] 			= $config["general"]["title"];
		$config["error"]["not_logged_in"]		= 'Du musst <a href="index.php" alt="sign in" style="color: #ed1515; text-decoration: underline;">eingeloggt</a> sein um dein Passwort zu ändern';

		/*Navi-bar*/
		$config["general"]["nav1"] 				= "Regeln";
		$config["general"]["lang"] 				= "Sprache";
		$config["general"]["home"]				= "home";
		
		/*Footer*/
		$config["general"]["footer"]			= "&copy;Suchtclub.de (2017-2018)";
		
		/*Profile*/
		$config["general"]["profile"]			= "Profil";
		$config["general"]["username"]			= "Benutzername";
		$config["general"]["email"]				= "E-Mail";
		$config["general"]["uid"]				= "Eindeutige Identifikation";
		$config["general"]["log"]				= "Log";
		$config["error"]["data"]				= "Fehler beim Laden der Nutzerdaten!";
		$config["interaction"]["change"]		= "ändern";
		$config["interaction"]["clear_log"]		= "Log löschen";
		
		/*Register*/
		$config["general"]["register"]			= "Registrieren";
		$config["general"]["password"]			= "Passwort";
		$config["general"]["password_repeat"]	= "Passwort wiederholen";
		$config["general"]["uid_enter"]			= "Gebe deine eindeutige Identifikation deines TeamSpeak Clients an";
		$config["general"]["validation_key"]	= "Verifikationsschlüssel";
		$config["error"]["email_invalid"]		= "Ungültige E-Mail";
		$config["error"]["email_used"]			= "E-Mail bereits benutzt";
		$config["error"]["no_username"]			= "Benutzernamen eingeben";
		$config["error"]["username_used"]		= "Benutzername bereits benutzt";
		$config["error"]["password_length"]		= "Passwort muss mindestens acht Zeichen lang sein";
		$config["error"]["password_mismatch"]	= "Passwörter stimmen nicht überein";
		$config["error"]["uid_not_online"]		= "Momentan ist kein Client mit dieser eindeutigen Identifikation online!";
		$config["interaction"]["uid_verify"]	= "Du musst in unserem TeamSpeak Server eingeloggt sein um dich zu registrieren!";
		$config["interaction"]["tip_uid"]		= "Du kannst deine eindeutige Identifikation im TeamSpeak Client unter Identitäten nachschauen!";
		$config["interaction"]["register_btn"]	= "Registrieren";
		
		/*E-Mail verification*/
		/***Generated E-Mail***/
		$config["email"]["title"]				= "Bitte bestätige deine E-Mail";
		$config["email"]["heading"]				= "Schließe deine Registration bei ".$config["general"]["title"]." ab indem du deine E-Mail bestätigst";
		$config["email"]["text"]				= "Du kannst deine E-Mail bestätigen indem du auf den Link unten klickst";
		$config["email"]["link_tip"]			= "Bestätige deine E-Mail!";
		$config["email"]["from"]				= "webmaster@".$config["general"]["title"];
		
		$config["general"]["email_success"]		= "Wir haben dir eine E-Mail geschickt, um sie zu verifizieren!";
		$config["general"]["verify_success"]	= "Danke, dass DU uns beigetreten bist!";
		$config["error"]["key_not_found"]		= "&#x26a0; Der Schlüssel, den du benutzt hast, ist uns nicht bekannt!";
		
		/*Main page*/
		/***TeamSpeak Panel***/
		$config["general"]["ts_address"]		= "Addresse";
		$config["general"]["ts_users_online"]	= "Nutzer online";
		$config["general"]["ts_country"]		= "Land";
		$config["interaction"]["ts_btn"]		= "Ansehen";
		$config["error"]["ts_not_found"]		= "Verbindung zum Server nicht möglich!";
		/***Login form***/
		$config["error"]["wrong_password"]		= "Falsches Passwort!";
		$config["error"]["wrong_email"]			= "Falsche E-Mail";
		$config["interaction"]["remember"]		= "angemeldet bleiben";
		$config["interaction"]["login"]			= "anmelden";
		$config["interaction"]["logout"]		= "abmelden";
		$config["interaction"]["register"]		= "registrieren";
		
		/*Change Password*/
		$config["general"]["change_password"]	= "Change password";
		$config["general"]["old_password"]		= "Old password";
		$config["general"]["new_password"]		= "New password";
		$config["general"]["change_success"]	= 'Dein Passwort wurde erfolgreich geändert! Zurück zur <a href="index.php" style="text-decoration underline; color: black;">homepage</a>!';
		$config["error"]["account_deleted"]		= 'Dein Konto wurde gelöscht! Zurück zur <a href="index.php" style="text-decoration underline; color: black;">homepage</a>!';
		$config["error"]["change_error"]		= $config["error"]["not_logged_in"];
		
		/*Teamspeak*/
		$config["error"]["ts_communication"]	= "Es ist ein Fehler bei der Kommunikation mit dem Server aufgetreten!";
		$config["error"]["ts_timeout"]			= "Die Verbindung hat zu lange gedauert...";
		$config["error"]["ts_try_again"]		= "Versuche es erneut in";
		$config["error"]["ts_restart"]			= "Neustarten...";
		$config["error"]["ts_reload"]			= "Lade neu...";
		$config["error"]["ts_invalid"]			= "Es konnte keine Verbindung hergestellt werden! Bitte versuche es später erneut";
		$config["error"]["ts_reload_btn"]		= "Neu laden";
		$config["error"]["log_in_to_view"]		= 'Du musst dich <a href="index.php" alt="sign in" style="color: #ed1515; text-decoration: underline;">anmelden</a>, um diese Seite zu sehen!';
		$config["error"]["invalid_ban"]			= "Du kannst diesen Benutzer nicht bannen";
		$config["error"]["invalid_id"]			= 'Nutzer mit dieser ID nicht gefunden!';
		$config["error"]["channel_del_failed"]	= "Dieser Kanal kann nicht gelöscht werden!";
		$config["error"]["channel_msg_failed"]	= "Kann diesem Kanal keine Nachricht senden!";
		$config["error"]["channel_not_found"]	= "Kann den angegebenen Kanal nicht finden!";
		$config["error"]["client_grps_load"]	= "Kann Servergruppen nicht laden!";
		$config["error"]["insufficient_power"]	= "Du hast nicht die notwendige Berechtigung, um die Seite anzusehen!";
		/***Channel***/
		$config["general"]["channel_deleted"]	= "Kanal erfolgreich gelöscht!";
		$config["general"]["channel_info"]		= "Kanalinfo";
		$config["general"]["channel_topic"]		= "Thema";
		$config["general"]["channel_desc"]		= "Beschreibung";
		$config["general"]["channel_duration"]	= "Haltbarkeit";
		$config["general"]["channel_codec"]		= "Codec";
		$config["general"]["channel_icon"]		= "Icon";
		$config["general"]["channel_talkpow"]	= "Nötige talk-power";
		$config["general"]["channel_max_client"]= "Nutzerlimit";
		$config["general"]["action"]			= "Aktionen";
		$config["interaction"]["channel_delete"]= "Löschen";
		$config["interaction"]["channel_msg"]	= "Nachricht";
		$config["interaction"]["send_btn"]		= "Senden";
		$config["interaction"]["channel_del_ok"]= "Bist du sicher, dass du diesen Kanal löschen möchtest? Du wirst ihn auf dieser Seite nicht wiederherstellen können!";
		/**Client**/
		$config["general"]["client_topic"]		= "Benutzerinfo: ";
		$config["general"]["client_desc"]		= "Beschreibung:";
		$config["general"]["client_muted"]		= "Stumm:";
		$config["general"]["client_muted_yes"]	= "ja";
		$config["general"]["client_muted_no"]	= "nein";
		$config["general"]["client_version"]	= "Version:";
		$config["general"]["client_country"]	= "Land:";
		$config["general"]["client_platform"]	= "Betriebssystem:";
		$config["general"]["client_last_login"]	= "Letzter login:";
		$config["general"]["client_talk_power"]	= "Talk power:";
		$config["general"]["client_global_id"]	= "Globale ID:";
		$config["general"]["client_server_grps"]= "Servergruppen:";
		$config["interaction"]["client_kick"]	= "Kicken";
		$config["interaction"]["reason"]		= "Grund:";
		$config["interaction"]["kick_server"]	= "vom Server";
		$config["interaction"]["kick_channel"]	= "vom Kanal";
		$config["interaction"]["client_ban"]	= "Bannen";
		$config["interaction"]["ban_duration"]	= "Dauer:";
		$config["interaction"]["ban_perm"]		= "Permanent";
		$config["interaction"]["client_poke"]	= "Anstupsen";
		$config["interaction"]["enter_msg"]		= "Nachricht eingeben:";
		/**Server**/
		$config["general"]["server_stopped"]	= "Server erfolgreich angehalten!";
		$config["general"]["server_started"]	= "Server erfolgreich gestartet!";
		$config["general"]["server_topic"]		= "Serverinfo:";
		$config["general"]["server_welcome"]	= "Willkommensnachricht:";
		$config["general"]["server_version"]	= "Version:";
		$config["general"]["server_clients"]	= "Benutzer:";
		$config["general"]["server_platform"]	= "Betriebssystem:";
		$config["general"]["server_created"]	= "Erstellt:";
		$config["general"]["server_uptime"]		= "Läuft seit:";
		$config["general"]["server_global_id"]	= "Globale ID:";
		$config["general"]["server_hostbanner"]	= "Hostbanner";
		$config["interaction"]["server_stop"]	= "Stoppen";
		
		/*Server panels*/
		$config["general"]["gameserver_version"]= "Version:";
		$config["general"]["gameserver_players"]= "Spieler:";
		$config["error"]["server_no_players"]	= "Es sind zurzeit keine Spieler online!";
		/**Minecraft Server**/
		$config["error"]["server_mc_offline"]	= "Unser Mincraftserver ist zurzeit offline";
		$config["error"]["mc_no_mods"]			= "Es sind keine Mdos installiert!";
		$config["general"]["mc_player_name_top"]= "Name";
		$config["general"]["mc_mod_name_top"]	= "Mod";
		$config["general"]["mc_mod_version_top"]= "Version";
		/**Garry's Mod Server**/
		$config["error"]["server_gm_offline"]	= "Unser Garry's Mod-Server ist zurzeit offline";
		$config["general"]["gm_player_name_top"]= "Name";
		$config["general"]["gm_player_scre_top"]= "Punkte";
		$config["general"]["gm_player_ip_top"]	= "IP";
		$config["general"]["gm_player_ping_top"]= "Verbindung";
		$config["general"]["gm_player_name_def"]= "Verbindet...";
		$config["general"]["gm_player_scre_def"]= "0";
		$config["general"]["gm_player_ip_def"]	= "Lädt...";
		$config["general"]["gm_player_ping_def"]= "Lädt...";
		$config["general"]["gm_vac_yes"]		= "ja";
		$config["general"]["gm_vac_no"]			= "nein";
		$config["general"]["gm_map"]			= "Karte:";
		$config["general"]["gm_mode"]			= "Modus:";
		$config["general"]["gm_vac"]			= "VAC-gesichert:";
		
		/*Chat*/
		$config["error"]["chat_no_partner"]		= 'Es wurde kein Chatpartner angegeben! <a href="index.php">Zurück zur homepage</a>';
		$config["general"]["chat_topic"]		= "Chat mit:";
		$config["general"]["chat_input_place"]	= "Hier schreiben...";
		$config["general"]["chat_limit_text"]	= "Zeichen übrig";
		$config["interaction"]["chat_limit"]	= 240;					//integer
		$config["interaction"]["chat_submit"]	= "Senden";
?>