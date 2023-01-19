# OpenConext-containers

## SSP Debug SP
The SSP debug SP container is specifically targeted for use with StepUp projects. The container is configured with 
a SP / IdP setup that tailors to use with StepUp authentication in mind. The debug SP (sp.php) can be used to fire
SSO and SFO authentications to the Gateway. 

In order to work with this container, you will need to do some small additional setting up in your own Dockerfile/Docker
Compose. 

1. Make sure you deploy a sp.key, idp.key, sp.crt and idp.crt to the `/var/cert` folder. They should match the SP 
   certificate of the SP's defined in your Gateway SAML entity setup. E.g the entities projected in 
   gateway.saml_entities`.
