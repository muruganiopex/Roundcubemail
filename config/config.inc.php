<?php

// SQL DATABASE
$config['db_dsnw'] = 'mysqli://roundcube:woFxXMhO8y6Nh9ojklCFRaN931YkpJ@127.0.0.1/roundcubemail';

// LOGGING
$config['log_driver'] = 'syslog';
$config['syslog_facility'] = LOG_MAIL;

// IMAP
$config['default_host'] = '127.0.0.1';
$config['default_port'] = 143;
$config['imap_auth_type'] = 'LOGIN';
$config['imap_delimiter'] = '/';
// Required if you're running PHP 5.6 or later
$config['imap_conn_options'] = array(
    'ssl' => array(
        'verify_peer'  => false,
        'verify_peer_name' => false,
    ),
);

// SMTP
$config['smtp_server'] = 'tls://127.0.0.1';
$config['smtp_port'] = 587;
$config['smtp_user'] = '%u';
$config['smtp_pass'] = '%p';
$config['smtp_auth_type'] = 'LOGIN';
// Required if you're running PHP 5.6 or later
$config['smtp_conn_options'] = array(
    'ssl' => array(
        'verify_peer'      => false,
        'verify_peer_name' => false,
    ),
);

// Use user's identity as envelope sender for 'return receipt' responses,
// otherwise it will be rejected by iRedAPD plugin `reject_null_sender`.
$config['mdn_use_from'] = true;

// SYSTEM
$config['force_https'] = true;
$config['login_autocomplete'] = 2;
$config['ip_check'] = true;
$config['des_key'] = '9CQDpTTrgOsLg9hkafw4PSBe';
$config['cipher_method'] = 'AES-256-CBC';
$config['useragent'] = 'Roundcube Webmail'; // Hide version number
//$config['username_domain'] = 'example.com';
$config['mime_types'] = '/etc/mime.types';

// USER INTERFACE
$config['create_default_folders'] = true;
$config['quota_zero_as_unlimited'] = true;

// USER PREFERENCES
$config['default_charset'] = 'UTF-8';
//$config['addressbook_sort_col'] = 'name';
$config['draft_autosave'] = 60;
$config['preview_pane'] = true;
$config['default_list_mode'] = 'threads';
$config['autoexpand_threads'] = 2;
$config['check_all_folders'] = true;
$config['default_font_size'] = '12pt';
$config['message_show_email'] = true;
//$config['skip_deleted'] = true;

// PLUGINS
$config['plugins'] = array('managesieve', 'password', 'enigma', 'calendar');


#
# "sql" is personal address book stored in roundcube database.
# "global_ldap_abook" is the new LDAP address book for AD, we will create it below.
#
$config['autocomplete_addressbooks'] = array("sql", "global_ldap_abook");

# Enable setting below if Roundcube returns 'user@127.0.0.1' as email address
#$config['mail_domain'] = '%d';

#
# Global LDAP Address Book with AD.
#
$config['ldap_public']["global_ldap_abook"] = array(
    'name'          => 'Global Address Book',
    'hosts'         => array("ad.example.com"), // <- Set AD hostname or IP address here.
    'port'          => 389,
    'use_tls'       => false,   // <- Set to true if you want to use LDAP over TLS.
    'ldap_version'  => '3',
    'network_timeout' => 10,
    'user_specific' => false,

    'base_dn'       => "dc=example,dc=com", // <- Set base dn in AD
    'bind_dn'       => "vmail",             // <- bind dn
    'bind_pass'     => "iopex@123", // <- bind password
    'writable'      => false,               // <- Do not allow mail user write data back to AD.

    'search_fields' => array('mail', 'cn', 'sAMAccountName', 'displayname', 'sn', 'givenName'),

    // mapping of contact fields to directory attributes
    'fieldmap' => array(
        'name'        => 'cn',
        'surname'     => 'sn',
        'firstname'   => 'givenName',
        'title'       => 'title',
        'email'       => 'mail:*',
        'phone:work'  => 'telephoneNumber',
        'phone:mobile' => 'mobile',
        'phone:workfax' => 'facsimileTelephoneNumber',
        'street'      => 'street',
        'zipcode'     => 'postalCode',
        'locality'    => 'l',
        'department'  => 'departmentNumber',
        'notes'       => 'description',
        'photo'       => 'jpegPhoto',
    ),
    'sort'          => 'cn',
    'scope'         => 'sub',
    'filter'        => "(|(&(objectclass=group)(!(groupType:1.2.840.113556.1.4.803:=2147483648)))(&(objectclass=person)(!(userAccountControl:1.2.840.113556.1.4.803:=2))))",
    'fuzzy_search'  => true,
    'vlv'           => false,   // Enable Virtual List View to more
                                // efficiently fetch paginated data
                                // (if server supports it)
    'sizelimit'     => '0',     // Enables you to limit the count of
                                // entries fetched. Setting this to 0
                                // means no limit.
    'timelimit'     => '0',     // Sets the number of seconds how long
                                // is spend on the search. Setting this
                                // to 0 means no limit.
    'referrals'     => false,   // Sets the LDAP_OPT_REFERRALS option.
                                // Mostly used in multi-domain Active
                                // Directory setups
);
