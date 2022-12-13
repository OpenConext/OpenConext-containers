# Introduction

The open source project "OpenConext" is a set of applications that are designed to run a identity federation proxy. The main protocol used is SAML. For service providers, OpenID Connect can be used as well. The application stack consists of a SAML gateway, combined with several other applications: A management UI to manage the entities, a Teams application to manage add hoc teams creation, a policy engine, a set of apps to manage second factor authentication.
The stack is designed to run on CentOS7, and uses a seperate Ansible repo to facilitate deployment.
The stack can be found here: https://github.com/OpenConext/. OpenConext-deploy can be found here: https://github.com/OpenConext/OpenConext-deploy

The OpenConext project is created and maintained by SURF, the Dutch National Research and Education network, and is used by several other organisations, like some Dutch ministries, and some other NRENs.
It is designed with flexibility and stability in mind: Flexibility to quickly add new feautures, and stability to facilitate a predictable login service that works 365/24/7, serving 50 users a second at peak times.

The stack consists of: 

Haproxy loadbalancer
Apache Webservers
PHP symfony apps, using PHP-FPM
Java springboot apps
Mongo database servers
mariadb / Galera database servers

Many more bits and pieces can be installed using the Ansible deployment scripts, like a stats application, Logstash pipeline definations for logging, central syslogs.

# The problem

* Maintaining and managing the development environments is time-consuming and complex.
* Developers at our development partners are increasingly using containers for other customers.
* It would be helpful for parties interested in using the open source project OpenConext to have a docker-compose file to get started.
* VMs are great for long term static workloads, but sometimes we need faster changes (like OS changes, or PHP version upgrades, composer upgrades, nodejs version differences). 
* We also see the world around us changing into a container-based world. That means that contributors to the OpenConext project are also more and more used to develop and run in containers.

# What we already have

We already have a part of the stack installed in a container: A GitHub action workflow will use the default centOS7 docker image, and will build a set of apps using ansible on that docker image, to be used in combination with the docker-compose.yml present in the OpenConext-deploy project.
We also use these to do integration tests on other projects, and for development of a seperate project, the SPdashboard which is also a PHP symfony app and can be used as reference (https://github.com/SURFnet/sp-dashboard). The base images used there are built from the official apache & php projects, and have some default stuff added so we have our own: https://github.com/OpenConext/OpenConext-containers

# The strategy

We would like to develop a container strategy that enables us to use containers for development, and later also use containers to run our production workloads. The main questions that should be answered in the strategy:

* Which base images should be used?
* Should we make our own base images (like we do in OpenConext-containers)
* How do we ensure that all security updates in the base image are quickly updated in our images?
* What is a useful tagging strategy?
* From which repos should we build our dockers? For example, a central repo or individual app repos?
* What do we do with the PHP-FPM + Apache dockers?
* How to handle Shibboleth: A daemon that integrates with Apache and handles authentications for our JAVA apps.
* The PHP webapps consist of static files (images, fonts, css and js) that are directly served by the webserver (Apache) and the PHP part that is dynamicly served using PHP-FPM. Hpwever both are part of the same application. How to handle that? Especially with GREEN/BLUE deployment strategies in mind.
* What is useful for apps that need to run together in one container?
* What is a suitable container platform for the production containers to land on? 
* Can we make Haproxy app aware in docker-compose? So all apps are added automatically?
* How to facilitate the ARM based CPU architectures of the new Macbooks?
* Where do we publish the containers?
* Do our apps need changes to facilitate the container strategy?
* PHP dev / prod differences: How to handle those? During development, with the app in "dev" mode, many files are generated dynamically to allow editing their imputs (i.e. jinja templates, DI configuration, less, typescript etc). This means that development tools like eg. nodejs and the php xdebug extension need to be available in the development container. Something like mailcatcher is required as well. The developer will want the directory with the source to be mounted from their local drive to allow interaction with the IDE. Setting up an app for development is now one of the things that require a lot of developer time. 

Ideally, we would not need to use a CentOS7 docker image with systemd and all apps installed on it anymore, but have one docker-compose.yml where all apps are inside it. 
It should then be possible to use that in the developement of the different apps that are running as a service eg: 

The central docker-compose run 3 services (serviceA, serviceB, serviceC, mongo and mysql). Now I want to develop the app of serviceA: It should be possible to use all the other apps when develop app A.

Furthermore, I believe that as little magic as possible should be run on the machines of the developers. So no scripts that run on a container after it starts for instance. The more is already prepped for them somewhere in the cloud, the faster they can start developing.
The container setup we use should allow both the production use-case where we precompile as much a possible at container build time as well as the development usecase were development tool are available and the application is run from source code. 
