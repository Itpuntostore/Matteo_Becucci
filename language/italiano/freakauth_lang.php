<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Language file needed by the FreakAuth library
 * @package     FreakAuth_light
 * @subpackage  Languages
 * @category    Authentication
 * @author      Daniel Vecchiato (danfreak)
 * @copyright   Copyright (c) 2007, 4webby.com
 * @license		http://www.gnu.org/licenses/lgpl.html
 * @link 		http://4webby.com/freakauth
 * @version 	1.1
 */

//------------------------------------------------------------------
//WEBSITE STUFF
//------------------------------------------------------------------
$lang['FAL_turned_off_message'] = 'Il sito %s e\' momentaneamente inaccessible per manutenzione.';
$lang['FAL_welcome'] = '';
$lang['FAL_email_halo_message'] = 'Caro';
$lang['FAL_user_name_label'] = 'Username';
$lang['FAL_user_password_label'] = 'Password';
$lang['FAL_user_password_confirm_label'] = 'Conferma Password';
$lang['FAL_user_email_label'] = 'Email';
$lang['FAL_user_autologin_label'] = 'Ricordami';
$lang['FAL_user_country_label'] = 'Nazione';

$lang['FAL_login_label'] = 'Login';
$lang['FAL_logout_label'] = 'Logout';

$lang['FAL_cancel_label'] = 'Cancella';
$lang['FAL_agree_label'] = 'I Accetta';
$lang['FAL_continue_label'] = 'Continua';
$lang['FAL_donotagree_label'] = 'I Non accetta';
$lang['FAL_forgotten_password_label'] = 'Password persa';
$lang['FAL_register_label'] = 'Registera';
$lang['FAL_registration_label'] = 'Registrazione';
$lang['FAL_change_password_label'] = 'Cambia Password';
$lang['FAL_activation_label'] = 'Attivazione utente';

$lang['FAL_citation_message'] = 'Grazie!';
$lang['FAL_already_logged_in_msg'] = 'Sei già loggato!';

$lang['FAL_unknown_user'] = 'Utente sconosciuto';

$lang['FAL_no_credentials_guest'] = 'Non hai i permessi per accedere all\' area richiesta, la preghiamo di effettuare il login e riprovare.';
$lang['FAL_no_credentials_user'] = 'Non hai i permessi per eseguire la richiesta.';

//------------------------------------------------------------------
//CAPTCHA
//------------------------------------------------------------------
$lang['FAL_captcha_label'] = 'Codice sicurezza';
$lang['FAL_captcha_message'] = 'Perfavore scrivi il codice che vedi nell\'immagine sopra';

//------------------------------------------------------------------
//REGISTRATION
//------------------------------------------------------------------
$lang['FAL_register_cancel_confirm'] = 'Vuoi veramente non accettare i termini di utilizzo?\\n\\n Premi cancella per continuare con la registrazione';

$lang['FAL_register_success_message'] = 'Grazie!<br />La tua registrazione e\' stata completata con successo.<br /><br />Le abbiamo inviato un email contenente le istruzioni per attivare la registrazione';

$lang['FAL_invalid_register_message'] = 'Registrazione non valida.';

$lang['FAL_terms_of_service_message'] =
'Tutti i messaggi postati in questo sito esprimono il punto di vista dell\'autore, e non necessariamente riflettono le opinioni di proprietari e amministratori di questo sito.

Con la registrazione a questo sito l\'utente accetta di non inviare nessun messaggio che sia osceno, volgari, diffamatori, di odio, minatori, o che violano le leggi. Faremo in modo permanente vietare tutti gli utenti che lo fanno.

Ci riserviamo il diritto di rimuovere, modificare, o spostare qualsiasi messaggio per qualsiasi motivo.
';

//------------------------------------------------------------------
//ACTIVATION
//------------------------------------------------------------------
$lang['FAL_activation_email_subject'] = 'Informazioni per l\'attivazione dell\' account';
$lang['FAL_activation_email_body_message'] = 
'Grazie per la vostra registrazione nuovo membro.

Per attivare il tuo nuovo account, si prega di visitare il seguente URL nelle prossime 24 ore:';

$lang['FAL_activation_login_instruction'] ='Dopo aver attivato il tuo accout e\' possibile effettuare il login come:';
$lang['FAL_activation_keep_data'] ='Tenere questa e-mail per riferimento futuro!';

$lang['FAL_activation_failed_message'] = 'Siamo spiacenti, ma la tua attivazione non è riuscita.\\n Contattare l\'amministratore del sito per ricevere assistenza.';
$lang['FAL_activation_success_message'] = 'Il tuo attivazione è stata completata con successo. Adesso potete effettuare il login.';




//------------------------------------------------------------------
//VALIDATION ERROR MESSAGES
//------------------------------------------------------------------
$lang['FAL_invalid_user_message'] = 'Utente non valido';
$lang['FAL_invalid_username_password_message'] = 'Username o password errati';
$lang['FAL_invalid_username_message'] = 'Username errato';
$lang['FAL_invalid_password_message'] = 'Password errata';
$lang['FAL_username_first_password_message'] = 'Perfavore inserire l\'username prima e dopo la passowrd';
$lang['FAL_banned_user_message'] = 'Sei stato bannato!';
$lang['FAL_login_message'] = 'Login effettuato con successo';
$lang['FAL_logout_message'] = 'Logout effettuato con successo';
$lang['FAL_length_validation_message'] = 'deve essere tra %s e %s caratteri di lunghezza.';
$lang['FAL_allowed_characters_validation_message'] = 'Solamente caratteri alfanumerici,numeri, _ , - ';
$lang['FAL_invalid_validation_message'] = '%s invalido: ';
$lang['FAL_in_use_validation_message'] = '%s gia\' utilizzato.';
$lang['FAL_country_validation_message'] = 'Perfavore scegli la nazione dove vivi';
$lang['FAL_user_email_duplicate'] = 'Un utente con questo indirizzo e-mail e\' gia\' registrato. Se hai dimenticato i tuoi dati di accesso si possono ottenere qui.';
$lang['FAL_usertemp_email_duplicate'] = 'Un utente con questo indirizzo e-mail e\' gi\' registrato ed e\' in attesa per l\'attivazione. Se questo e\' il vostro indirizzo e-mail si prega di controllare la vostra casella di posta elettronica e attivare il tuo account.';
 
//------------------------------------------------------------------
//CHANGE PASSWORD
//------------------------------------------------------------------
$lang['FAL_change_password_success'] = 'La password e\' stata cambiata con successo';
$lang['FAL_old_password_label'] = 'Vecchia Password';
$lang['FAL_new_password_label'] = 'Nuova Password';
$lang['FAL_retype_new_password_label'] = 'Conferma';
$lang['FAL_submit'] = 'Invia';
$lang['FAL_reset'] = 'Cancella';
$lang['FAL_change_password_failed_message'] = 'Informazioni non valide';

//------------------------------------------------------------------
//FORGOTTEN PASSWORD
//------------------------------------------------------------------
//->email
$lang['FAL_forgotten_password_email_subject'] = 'Istruzioni recupero password';
$lang['FAL_forgotten_password_email_reset_subject'] = 'Nuove informazioni di login';
$lang['FAL_forgotten_password_email_header_message'] = 'Per resettare la password connettersi alla seguente pagina:';
$lang['FAL_forgotten_password_email_body_message'] = 
'
Tu o qualcun altro ha chiesto di reimpostare la password del tuo account.

Se non ricordi la password e si desidera modificarla, clicca sul seguente link:';

$lang['FAL_forgotten_password_email_body_message2'] ='Se non l\'hai richiesta ignora questa email.';

$lang['FAL_forgotten_password_reset_email_body_message'] = 'Queste sono le tue nuove credenziali di accesso:';
$lang['FAL_forgotten_password_reset_email_user_label'] = 'Username';
$lang['FAL_forgotten_password_reset_email_password_label'] = 'Password';

$lang['FAL_forgotten_password_email_change_message'] = 'Per modificare la password assegnata collegarsi alla seguente pagina:';

//->messages
$lang['FAL_forgotten_password_success_message'] = 'Le istruzioni per resettare la password ti sono state inviate via email';
$lang['FAL_forgotten_password_user_not_found_message'] = 'Siamo spiacenti ma non abbiamo trovato nessun account con l\'email fornita';
$lang['FAL_forgotten_password_reset_failed_message'] = 'Siamo spiacenti ma il reset della password è fallito. \n La preghiamo di contattare l\'assistenza';
$lang['FAL_forgotten_password_reset_success_message'] = 'La tua password e\' stata resettate con successo ed inviata via email';

//------------------------------------------------------------------
//FLASH MESSAGES
//------------------------------------------------------------------
$lang['FAL_user_added'] = ' Nuovo utente aggiunto con successo!';
$lang['FAL_user_edited'] = ' Utente modificato con successo!';
$lang['FAL_user_deleted'] = ' Utente eliminato con successo!';
$lang['FAL_no_permissions'] = 'Non hai i diritti per accedere a questra area.';

//------------------------------------------------------------------
//OTHER MESSAGES
//------------------------------------------------------------------
$lang['FAL_no_DB_data'] = 'Nessun dato nel database: perfavore aggiungerli!';
$lang['FAL_confirm_delete'] = 'Vuoi veramente eliminare questo record?';
?>