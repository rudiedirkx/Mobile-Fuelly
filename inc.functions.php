<?php

function persistSession() {
	global $client;
	setcookie('fuelly_session', $client->auth->session);
}

function html( $text ) {
	return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8') ?: htmlspecialchars((string)$text, ENT_QUOTES, 'ISO-8859-1');
}
