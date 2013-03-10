<h1>SSL Zertifikat (Security first)</h1>

<p>
Bevor wir uns dran machen den WebServer einzurichten benötigen wir zuerst ein 
SSL Zertifikat, um die Kommunikation abzusichern.
Dazu wird das Packet <span class="software" >openssl</span> benötigt. Wenn nicht
vorhanden bitte über den Packetmanager (Wenn uns schon jemand die Arbeit mit dem
Patchen abnimmt) nachinstallieren.
</p>

<p>
Um später Trusted User verwalten zu können benötigen wir ein "Certification Authority (CA)" Zertifikat,
welches uns ermöglicht SSL und TLS Zertifikate zu erstellen und zu beglaubigen.
</p>

<label>Befehle zum erstellen eines Zertifikats</label>
<?php start_highlight(); ?>
$ /usr/lib/ssl/misc/CA.pl -newca 
<?php display_highlight( 'bash' ); ?>

<pre>
CA certificate filename (or enter to create) # wir wollen erstelle als Enter

Making CA certificate ...
Generating a 1024 bit RSA private key
............................++++++
....................++++++
writing new private key to './demoCA/private/cakey.pem'
Enter PEM pass phrase:  # Ein wirklich sicheres Passwort (<a>Schwache Passwörter</a>) angeben
Verifying - Enter PEM pass phrase:                        
-----
You are about to be asked to enter information that will be incorporated
into your certificate request.
What you are about to enter is what is called a Distinguished Name or a DN.
There are quite a few fields but you can leave some blank
For some fields there will be a default value,
If you enter '.', the field will be left blank.
-----
Country Name (2 letter code) [AU]:DE
State or Province Name (full name) [Some-State]:BW
Locality Name (eg, city) []:YourCity
Organization Name (eg, company) [Internet Widgits Pty Ltd]:YourCompany
Organizational Unit Name (eg, section) []:IT   
Common Name (eg, YOUR name) []:YourBoss
Email Address []:it@yourdomain.de

Please enter the following 'extra' attributes
to be sent with your certificate request
A challenge password []:      # ignorieren und Enter drücken
An optional company name []:  # ignorieren und Enter drücken
Using configuration from /usr/lib/ssl/openssl.cnf
Enter pass phrase for ./demoCA/private/cakey.pem: # das lange gute pwd eingeben
Check that the request matches the signature
Signature ok
Certificate Details:
        Serial Number:
            f7:50:b3:a4:b9:f6:b1:9c
        Validity
            Not Before: Jan  8 14:51:51 2012 GMT
            Not After : Jan  7 14:51:51 2015 GMT
        Subject:
            countryName               = DE
            stateOrProvinceName       = BW
            organizationName          = YourCompany
            organizationalUnitName    = IT
            commonName                = YourBoss
            emailAddress              = it@yourdomain.de
        X509v3 extensions:
            X509v3 Subject Key Identifier: 
                A9:43:15:2F:CE:ED:44:A6:3C:A4:9B:76:24:5B:FA:5C:7A:DC:9F:23
            X509v3 Authority Key Identifier: 
                keyid:A9:43:15:2F:CE:ED:44:A6:3C:A4:9B:76:24:5B:FA:5C:7A:DC:9F:23
                DirName:/C=DE/ST=BW/O=YourCompany/OU=IT/CN=YourBoss/emailAddress=it@yourdomain.de
                serial:F7:50:B3:A4:B9:F6:B1:9C

            X509v3 Basic Constraints: 
                CA:TRUE
Certificate is to be certified until Jan  7 14:51:51 2015 GMT (1095 days)

Write out database with 1 new entries
Data Base Updated
</pre>