Overview
========

LOCKSS-O-Matic helps automate the ingestion of content into a
[Private LOCKSS Network](http://www.lockss.org/community/networks/) (PLN).
It also monitors the PLN to ensure that all member boxes are online and
operating normally.

The LOCKSS-O-Matic web application acts as the "admin server" for the PLN,
which means that the LOCKSS boxes in the network use it as the source for the
configuration files that govern what content they harvest and preserve.
LOCKSS-O-Matic derives these configration files from its interaction with
other applications (known as content providers) or from humans registering
content to be preserved using a set of in-browser tools. LOCKSS-O-Matic
implements the [SWORD](http://swordapp.org/) protocol to communicate with
content providers. The first two content providers will
be [Archivematica](https://www.archivematica.org) and
[Open Journal Systems](http://pkp.sfu.ca/ojs/) but LOCKSS-O-Matic can be used
with any content management system or other type of application that produces
content to be preserved in a LOCKSS network.

Networks
========

LOCKSS-O-Matic does not deploy LOCKSS networks - currently that must be done by
system administrators. However, LOCKSS-O-Matic will provide tools to generate
configuration files for the boxes in the network. Once a network is operational,
getting content into it will be as easy as registering a list of URLs to harvest,
provided they are compatible with the included LOCKSS plugins (which, initially,
means that the files are compressed archives such as ZIP, 7z, or tgz formats).
 types of content will be possible with the appropraite LOCKSS plugins.
Archivematica will include a plugin to enable integration with LOCKSS-O-Matic.


Quality Tools
-------------

PHP Unit

`./vendor/bin/phpunit`

`./vendor/bin/phpunit --coverage-html=web/docs/coverage`

Sami

`sami -vv update --force sami.php`

PHP CS

`./vendor/bin/phpcs --report-xml=tmp.xml`

`saxon -xsl:phpcs.xsl -s:tmp.xml -o:web/docs/phpcs/index.html`

Sphinx

TBD
