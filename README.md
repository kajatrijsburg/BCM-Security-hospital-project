# Security & BCM Prototype website

Dit is een nogal *onveilige* website waarmee studenten in de module Security & BCM (Jaar 2, periode 3) aan de slag moeten. 

Het doel is om een aantal basis technieken te laten zien
  1. verbinding maken met LDAP voor het maken/uitlezen van een nieuwe gebruiker
  1. verbinding maken met MySQL database
  1. een beveiligde pagina (/intranet) maken waarbij ingelogd moet worden via BasicAuth


# Installatie en doorontwikkeling door teams
  
Deze website staat op de Virtuele Machine die studenten aangeleverd krijgen. Je vind deze broncode in de map
`/var/www/energy`. Je kunt deze door middel van een `git pull` up-to-date maken. 

Ga vervolgens verder met deze versie door je eigen `git remote` toe te voegen 
([link](https://git-scm.com/book/en/v2/Git-Basics-Working-with-Remotes)) zodat je met je 
team kunt samenwerken in je eigen repository.

# Uitleg over de structuur van deze website 
De website bestaat uit twee hoofdbestanddelen:
  * Publieke website
  * Afgeschermde website

Het publieke deel is dus voor alle gebruikers beschikbaar. Bestanden staan in de root van deze map of daar onder.

Het afgeschermde deel (vaak 'intranet' genoemd) staat in de map `intranet`. Alle bestanden die in deze map
(of submappen) staan, zijn afgeschermd door middel van een gebruikersnaam en wachtwoord. Je kunt hiermee
alleen inloggen als je ook een correct opgezet account hebt in de LDAP-administratie (meer hierover in de lessen).

# Voorbeelden
Er zitten diverse stukken voorbeeld code in deze website waar je naar kunt kijken voor je eigen echte
website.

## Database gebruik
In het bestand `./partials/footer.php` staat code hoe je een MariaDB of MySQL database kunt benaderen
via PDO ([Link PHP.net](https://www.php.net/manual/en/class.pdo.php)). Deze PDO-klassen zijn standaard
beschikbaar. Kijk goed naar dit voorbeeld als je nog nooit met PHP en een database hebt gewerkt. Zorg
dat je *altijd* werkt met `prepared statements` ([Link PHP.net](https://www.php.net/manual/en/class.pdostatement.php))
om te voorkomen dat je bepaalde zwakheden introduceert. Gebruik *altijd* `placeholders` 
([PDO Binding](https://www.php.net/manual/en/pdostatement.bindcolumn.php)) in plaats van
input van gebruikers rechtstreeks in je SQL op te nemen (zie ook 
[OWASP SQL Injection](https://owasp.org/www-community/attacks/SQL_Injection)). 

**Let op**: in het voorbeeld zijn nog geen parameters gebruikt, omdat dat hier niet nodig is. Je ziet al 
wel dat er een `prepare` wordt gedaan op de uit te voeren SQL.

## Interfacing met LDAP
Het werken met LDAP is nogal complex. Vandaar dat er een voorbeeld is gemaakt om zowel de LDAP te bevragen
en daar wijzigingen op uit te voeren. 

Dit voorbeeld vindt je in `./intranet/createNewUser.php`. Deze maakt gebruik van een aantal functies
in de bibliotheek `./intranet/ldap_support.inc.php`. Bestudeer deze goed om zo je eigen website goed 
aan te sluiten op LDAP.
