<?php

// MANAGED BY ANSIBLE

// This file defines remote IdPs. These are the IdPs that the SPs hosted by this SSP instance can use for
// authentication


////////////////////////////////////////////////////////////////////////////
// Idp remote metadata of the IdP hosted at this instance (ssp.stepup.example.com), for use by the hosted SPs

$metadata['https://ssp.stepup.example.com/saml2/idp/metadata.php'] = array (
    'entityid' => 'https://ssp.stepup.example.com/saml2/idp/metadata.php',
    'signature.algorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
    'certificate' => 'idp.crt',
    'SingleSignOnService' =>
        array (
            0 =>
                array (
                    'Binding' => $GLOBALS['gSP_SSOBinding'],
                    'Location' => 'https://ssp.stepup.example.com/saml2/idp/SSOService.php',
                ),
        ),
    'ArtifactResolutionService' =>
        array (
            0 =>
                array (
                    'index' => 0,
                    'Location' => 'https://ssp.stepup.example.com/saml2/idp/ArtifactResolutionService.php',
                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
                ),
        ),
    'name' => array(
        'en' => 'ssp.stepup.example.com - SSP Test IdP',
        'nl' => 'ssp.stepup.example.com - SSP Test IdP',
    ),

);


////////////////////////////////////////////////////////////////////////////
// The metadata of the OpenConext Stepup IdP, for use by the hosted SPs

$metadata['https://gateway.stepup.example.com/authentication/metadata'] = array (
    'entityid' => 'https://gateway.stepup.example.com/authentication/metadata',
    //'signature.algorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
    'contacts' =>
        array (
        ),
    'metadata-set' => 'saml20-idp-remote',
    'SingleSignOnService' =>
        array (
            0 =>
                array (
                    'Binding' => $GLOBALS['gSP_SSOBinding'],
                    'Location' => 'https://gateway.stepup.example.com/authentication/single-sign-on',
                ),
        ),
    'SingleLogoutService' =>
        array (
        ),
    'ArtifactResolutionService' =>
        array (
        ),
    'keys' =>
        array (
            0 =>
                array (
                    'encryption' => false,
                    'signing' => true,
                    'type' => 'X509Certificate',
                    'X509Certificate' => depem(file_get_contents('/app/cert/idp.crt')),
                ),
        ),
);

if ( isset($_COOKIE['testcookie']) ) {
    $metadata['https://gateway.stepup.example.com/authentication/metadata']['keys'][0]['X509Certificate'] = depem(file_get_contents('/vagrant/deploy/tests/behat/fixtures/test_public_key.crt'));
}

////////////////////////////////////////////////////////////////////////////
// The metadata of the OpenConext Stepup IdP - SFO, for use by the hosted SPs

$metadata['https://gateway.stepup.example.com/second-factor-only/metadata'] = array (
    'entityid' => 'https://gateway.stepup.example.com/second-factor-only/metadata',
    //'signature.algorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
    'contacts' =>
        array (
        ),
    'metadata-set' => 'saml20-idp-remote',
    'SingleSignOnService' =>
        array (
            0 =>
                array (
                    'Binding' => $GLOBALS['gSP_SSOBinding'],
                    'Location' => 'https://gateway.stepup.example.com/second-factor-only/single-sign-on',
                ),
        ),
    'SingleLogoutService' =>
        array (
        ),
    'ArtifactResolutionService' =>
        array (
        ),
    'keys' =>
        array (
            0 =>
                array (
                    'encryption' => false,
                    'signing' => true,
                    'type' => 'X509Certificate',
                    'X509Certificate' => depem(file_get_contents('/app/cert/idp.crt')),
                ),
        ),
);

if ( isset($_COOKIE['testcookie']) ) {
    $metadata['https://gateway.stepup.example.com/second-factor-only/metadata']['keys'][0]['X509Certificate'] = depem(file_get_contents('/vagrant/deploy/tests/behat/fixtures/test_public_key.crt'));
}

/**
 * Remove the spicing from the certificate, this is a php port of the python (keyczar) implementation that is used
 * in the ninja templates ( return re.sub(r'\s+|(-----(BEGIN|END).*-----)', '', string) )
 */
function depem($input)
{
    return str_replace([
        '-----BEGIN CERTIFICATE-----',
        '-----END CERTIFICATE-----',
        "\r\n",
        "\n",
    ], [
        '',
        '',
        "\n",
        ''
    ], $input);
}
