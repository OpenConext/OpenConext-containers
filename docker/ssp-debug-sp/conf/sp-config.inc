<?php

$_SERVER['HTTPS'] = 'on';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// List of the avaiable remote SAML 2.0 identity providers in the SP interface
// The SP interface allows selection of the IdP and the (Requested) AuthnContextClassRef
// The IdP must be configured in saml20-idp-remote.php

$gIDPmap = array(
    /*
    'EntityID of the IdP as it appers in saml20-idp-remote.php' => array(
        'name' => 'Displayname of the IdP in the SP interface',
        'loa' => array(
          1 => 'AuthnContextClassRef for loa 1',
          2 => 'AuthnContextClassRef for loa 2',
          3 => 'AuthnContextClassRef for loa 3',
        ),
    )
    */
    'https://gateway.stepup.example.com/authentication/metadata' => array(
        'name' => 'OpenConext Stepup Gateway - gateway.stepup.example.com',
        'loa' => array(
            '1.5' => 'http://stepup.example.com/assurance/loa-self-asserted',
            1 => 'http://stepup.example.com/assurance/level1',
            2 => 'http://stepup.example.com/assurance/level2',
            3 => 'http://stepup.example.com/assurance/level3',
        ),
    ),
    'https://gateway.stepup.example.com/second-factor-only/metadata' => array(
        'name' => 'OpenConext Stepup Gateway - gateway.stepup.example.com - SFO',
        'loa' => array(
            '1.5'=> 'http://stepup.example.com/assurance/loa-self-asserted',
            1 => 'http://no.level.1.for.sfo.example.com/assurance/sfo-level1', // Note does not exist
            2 => 'http://stepup.example.com/assurance/sfo-level2',
            3 => 'http://stepup.example.com/assurance/sfo-level3',
        ),
    ),
    'https://ssp.stepup.example.com/saml2/idp/metadata.php' => array(
        'name' => 'Local SSP IdP - ssp.stepup.example.com',
        'loa' => array(
            '1.5' => '',
            1 => '',
            2 => '',
            3 => '',
        ),
    ),
);
