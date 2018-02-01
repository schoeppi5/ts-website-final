<?php
		/*General Information*/
		$config["general"]["title"] 			= "Suchtclub.de";
		$config["general"]["heading"] 			= $config["general"]["title"];
		$config["error"]["not_logged_in"]		= 'You need to be <a href="index.php" alt="sign in" style="color: #ed1515; text-decoration: underline;">signed in</a> to change your password!';

		/*Navi-bar*/
		$config["general"]["nav1"] 				= "Rules";
		$config["general"]["lang"] 				= "language";
		$config["general"]["home"]				= "home";
		
		/*Footer*/
		$config["general"]["footer"]			= "&copy;Suchtclub.de (2017-2018)";
		
		/*Profile*/
		$config["general"]["profile"]			= "Profile";
		$config["general"]["username"]			= "Username";
		$config["general"]["email"]				= "E-Mail";
		$config["general"]["uid"]				= "Unique Identifier";
		$config["general"]["log"]				= "Log";
		$config["error"]["data"]				= "An error occurred while loading userdata!";
		$config["interaction"]["change"]		= "change";
		$config["interaction"]["clear_log"]		= "Clear log";
		
		/*Register*/
		$config["general"]["register"]			= "Register";
		$config["general"]["password"]			= "Password";
		$config["general"]["password_repeat"]	= "Repeat password";
		$config["general"]["uid_enter"]			= "Enter your TeamSpeak Unique Identifier";
		$config["general"]["validation_key"]	= "Validation_key";
		$config["error"]["email_invalid"]		= "Invalid E-Mail";
		$config["error"]["email_used"]			= "E-Mail already used";
		$config["error"]["no_username"]			= "Enter username";
		$config["error"]["username_used"]		= "Username already used";
		$config["error"]["password_length"]		= "Password must be atleast eight characters long";
		$config["error"]["password_mismatch"]	= "Passwords doesn&apos;t match";
		$config["error"]["uid_not_online"]		= "There is no client currently online with this Global ID! Please make sure you&apos;ve joined us before!";
		$config["interaction"]["uid_verify"]	= "You have to be logged in to our TeamSpeak in order to register!";
		$config["interaction"]["tip_uid"]		= "You can retrieve your unique identifier in your identity settings!";
		$config["interaction"]["register_btn"]	= "Register";
		
		/*E-Mail verification*/
		/***Generated E-Mail***/
		$config["email"]["title"]				= "Verify your E-Mail address";
		$config["email"]["heading"]				= "Join ".$config["general"]["title"]." by verifying your E-Mail address";
		$config["email"]["text"]				= "Please verify your E-Mail address by clicking the link below to complete your registration process for ".$config["general"]["title"];
		$config["email"]["link_tip"]			= "Verify your E-Mail!";
		$config["email"]["from"]				= "webmaster@".$config["general"]["title"];
		
		$config["general"]["email_success"]		= "We have send you an E-Mail to validate your E-Mail address! Please follow the link in the E-Mail!";
		$config["general"]["verify_success"]	= "Thanks for joining us!";
		$config["error"]["key_not_found"]		= "&#x26a0; You have used an unknown key!";
		
		/*Main page*/
		/***TeamSpeak Panel***/
		$config["general"]["ts_address"]		= "Address";
		$config["general"]["ts_users_online"]	= "Users online";
		$config["general"]["ts_country"]		= "Country";
		$config["interaction"]["ts_btn"]		= "Take a look";
		$config["error"]["ts_not_found"]		= "Can&apos;t connect to server!";
		/***Login form***/
		$config["error"]["wrong_password"]		= "Wrong password!";
		$config["error"]["wrong_email"]			= "Wrong E-Mail";
		$config["interaction"]["remember"]		= "Remember me";
		$config["interaction"]["login"]			= "login";
		$config["interaction"]["logout"]		= "logout";
		$config["interaction"]["register"]		= "register";
		
		/*Change Password*/
		$config["general"]["change_password"]	= "Change password";
		$config["general"]["old_password"]		= "Old password";
		$config["general"]["new_password"]		= "New password";
		$config["general"]["change_success"]	= 'Password changed successfully! Back to <a href="index.php" style="text-decoration underline; color: black;">homepage</a>!';
		$config["error"]["account_deleted"]		= 'Your account was deleted! Back to <a href="index.php" title="Log in">homepage</a>';
		$config["error"]["change_error"]		= $config["error"]["not_logged_in"];
		
		/*Teamspeak*/
		$config["error"]["ts_communication"]	= "Error while communicating with server!";
		$config["error"]["ts_timeout"]			= "Connection timeout...";
		$config["error"]["ts_try_again"]		= "Trying again in";
		$config["error"]["ts_restart"]			= "Restarting...";
		$config["error"]["ts_reload"]			= "Reload...";
		$config["error"]["ts_invalid"]			= "Connection Invalid! Please try again later";
		$config["error"]["ts_reload_btn"]		= "Reload";
		$config["error"]["log_in_to_view"]		= 'You need to be <a href="index.php" alt="sign in" style="color: #ed1515; text-decoration: underline;">logged in</a> to view this site!';
		$config["error"]["invalid_ban"]			= "You can't ban this client";
		$config["error"]["invalid_id"]			= 'There is no Client online with this ID!';
		$config["error"]["channel_del_failed"]	= "Unable to delete channel!";
		$config["error"]["channel_msg_failed"]	= "Unable to send message to this channel!";
		$config["error"]["channel_not_found"]	= "Unable to find channel!";
		$config["error"]["client_grps_load"]	= "Can't load servergroups!";
		$config["error"]["insufficient_power"]	= "You do not have the required permission to visit this page!";
		/***Channel***/
		$config["general"]["channel_deleted"]	= "Channel successfully deleted!";
		$config["general"]["channel_info"]		= "Channel info";
		$config["general"]["channel_topic"]		= "Topic";
		$config["general"]["channel_desc"]		= "Description";
		$config["general"]["channel_duration"]	= "Duration";
		$config["general"]["channel_codec"]		= "Codec";
		$config["general"]["channel_icon"]		= "Icon";
		$config["general"]["channel_talkpow"]	= "Needed talk-power";
		$config["general"]["channel_max_client"]= "Maximum clients";
		$config["general"]["action"]			= "Actions";
		$config["interaction"]["channel_delete"]= "Delete";
		$config["interaction"]["channel_msg"]	= "Message";
		$config["interaction"]["send_btn"]		= "Send";
		$config["interaction"]["channel_del_ok"]= "Are you sure you want to delete this channel? You won&apos;t be able to re-create it on this webpage!";
		/**Client**/
		$config["general"]["client_topic"]		= "Client Info: ";
		$config["general"]["client_desc"]		= "Description:";
		$config["general"]["client_muted"]		= "Muted:";
		$config["general"]["client_muted_yes"]	= "yes";
		$config["general"]["client_muted_no"]	= "no";
		$config["general"]["client_version"]	= "Version:";
		$config["general"]["client_country"]	= "Country:";
		$config["general"]["client_platform"]	= "Platform:";
		$config["general"]["client_last_login"]	= "Last login:";
		$config["general"]["client_talk_power"]	= "Talk power:";
		$config["general"]["client_global_id"]	= "Global ID:";
		$config["general"]["client_server_grps"]= "Servergroups:";
		$config["interaction"]["client_kick"]	= "Kick";
		$config["interaction"]["reason"]		= "Reason:";
		$config["interaction"]["kick_server"]	= "from Server";
		$config["interaction"]["kick_channel"]	= "from Channel";
		$config["interaction"]["client_ban"]	= "Ban";
		$config["interaction"]["ban_duration"]	= "Duration:";
		$config["interaction"]["ban_perm"]		= "Permanent";
		$config["interaction"]["client_poke"]	= "Poke";
		$config["interaction"]["enter_msg"]		= "Enter message:";
		/**Server**/
		$config["general"]["server_stopped"]	= "Server stopped successfully!";
		$config["general"]["server_started"]	= "Server started successfully!";
		$config["general"]["server_topic"]		= "Server Info:";
		$config["general"]["server_welcome"]	= "Welcome message:";
		$config["general"]["server_version"]	= "Version:";
		$config["general"]["server_clients"]	= "Clients:";
		$config["general"]["server_platform"]	= "Platform:";
		$config["general"]["server_created"]	= "Created:";
		$config["general"]["server_uptime"]		= "Uptime:";
		$config["general"]["server_global_id"]	= "Global ID:";
		$config["general"]["server_hostbanner"]	= "Hostbanner";
		$config["interaction"]["server_stop"]	= "Stop";
		
		/*Server panels*/
		$config["general"]["gameserver_version"]= "Version:";
		$config["general"]["gameserver_players"]= "Players:";
		$config["error"]["server_no_players"]	= "There are currently no players online!";
		/**Minecraft Server**/
		$config["error"]["server_mc_offline"]	= "Our Minecraftserver is currently offline";
		$config["error"]["mc_no_mods"]			= "There are no mods installed!";
		$config["general"]["mc_player_name_top"]= "Name";
		$config["general"]["mc_mod_name_top"]	= "Mod";
		$config["general"]["mc_mod_version_top"]= "Version";
		/**Garry's Mod Server**/
		$config["error"]["server_gm_offline"]	= "Our Garry's Mod Server is currently offline";
		$config["general"]["gm_player_name_top"]= "Name";
		$config["general"]["gm_player_scre_top"]= "Score";
		$config["general"]["gm_player_ip_top"]	= "IP";
		$config["general"]["gm_player_ping_top"]= "Ping";
		$config["general"]["gm_player_name_def"]= "Joining...";
		$config["general"]["gm_player_scre_def"]= "0";
		$config["general"]["gm_player_ip_def"]	= "Loading...";
		$config["general"]["gm_player_ping_def"]= "Loading...";
		$config["general"]["gm_vac_yes"]		= "yes";
		$config["general"]["gm_vac_no"]			= "no";
		$config["general"]["gm_map"]			= "Map:";
		$config["general"]["gm_mode"]			= "Mode:";
		$config["general"]["gm_vac"]			= "VAC-protected:";
		
		/*Chat*/
		$config["error"]["chat_no_partner"]		= 'There is no chatpartner specified! <a href="index.php">Back to homepage</a>';
		$config["general"]["chat_topic"]		= "Chat with:";
		$config["general"]["chat_input_place"]	= "Type here...";
		$config["general"]["chat_limit_text"]	= "characters left";
		$config["interaction"]["chat_limit"]	= 240;					//integer
		$config["interaction"]["chat_submit"]	= "Send";
?>