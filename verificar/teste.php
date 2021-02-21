<?php
$ldapconfig['host']= '172.31.0.41';//AD-001
$ldapconfig['port']= '389';//Porta Padrão
$ldapconfig['dn'] = "dc=dajutec,dc=local";
$domain= 'dajutec';
$username = 'gabriely.scheleider';
$password = 'D@ju*2020!AV';

//Faz conexão com AD usando LDAP
$sn= ldap_connect($ldapconfig['host'], $ldapconfig['port']);
ldap_set_option($sn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($sn, LDAP_OPT_REFERRALS, 0);

@$bind=ldap_bind($sn, $username .'@'.$domain, $password);

    if($bind == '1'){
        $filter = "(sAMAccountName=$username)";
        $attributes = array('mail', 'name');
        
        $search = ldap_search($sn,'dc=dajutec,dc=local', $filter, $attributes);
        
        $data = ldap_get_entries($sn, $search);
        
        foreach ($data AS $key => $value){
            print_r($value);
            echo @$value["name"][0]."<br>";
            echo @$value["mail"][0]."<br>";
        }
    }else{
        echo 'nada';
    }



/* 
// using ldap bind
$ldaprdn  = $username;     // ldap rdn or dn
$ldappass = $password;  // associated password

// connect to ldap server
$ldapconn = ldap_connect('172.31.0.41')
    or die("Could not connect to LDAP server.");

if ($ldapconn) {

    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

    // verify binding
    if ($ldapbind) {
        echo "LDAP bind successful...";
    } else {
        echo "LDAP bind failed...";
    }

} */

/* 
$ldap_server = '172.31.0.41';
$dominio = 'dajutec/'; //Dominio local ou global
$user = $dominio.'gabriely.scheleider';
$ldap_porta = '389';
$ldap_pass   = 'D@ju*2020!AV';
$ldapcon = ldap_connect($ldap_server, $ldap_porta) or die('Could not connect to LDAP server.');

if ($ldapcon){

// binding to ldap server
//$ldapbind = ldap_bind($ldapconn, $user, $ldap_pass);

    $bind = ldap_bind($ldapcon, $user, $ldap_pass);

    // verify binding
    if ($bind) {
        echo "LDAP bind successful…";
    }else{
        echo "LDAP bind failed…";
    }

} */

?>
