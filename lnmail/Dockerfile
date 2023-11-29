# Use the official Debian Buster image as the base image
FROM debian:buster-slim

# Preconfigure Postfix and Roundcube
RUN echo "postfix postfix/mailname string lnmail.com" | debconf-set-selections && \
    echo "postfix postfix/main_mailer_type string 'Local only'" | debconf-set-selections && \
    echo "roundcube-core roundcube/dbconfig-install boolean false" | debconf-set-selections

# Install necessary packages
RUN apt-get update && apt-get install -y \
    iputils-ping \
    apache2 \
    dovecot-core \
    dovecot-imapd \
    postfix \
    roundcube \
    roundcube-core \
    roundcube-mysql \
    roundcube-plugins \
    mariadb-server \
    php-mysql \
    && rm -rf /var/lib/apt/lists/*

# Configure Apache to serve Roundcube
RUN ln -sf /usr/share/roundcube /var/www/html/roundcube

# Configure MySQL
RUN service mysql start && \
    mysql -e "CREATE DATABASE roundcube;" && \
    mysql -e "CREATE USER 'roundcube'@'localhost' IDENTIFIED BY 'password';" && \
    mysql -e "GRANT ALL PRIVILEGES ON roundcube.* TO 'roundcube'@'localhost';" && \
    mysql -e "FLUSH PRIVILEGES;" && \
    mysql roundcube < /usr/share/roundcube/SQL/mysql.initial.sql

# Add configuration for Roundcube
COPY lnmail/roundcube-config.inc.php /etc/roundcube/config.inc.php

# Add configuration for Roundcube
RUN echo "<?php\n\$config['db_dsnw'] = 'mysqli://roundcube:password@localhost/roundcube';" > /etc/roundcube/debian-db.php

RUN echo "<?php\n\$config['log_driver'] = 'file';\n\$config['log_dir'] = '/var/log/roundcube/';" >> /etc/roundcube/config.inc.php

RUN echo "error_log = /var/log/php/error.log" >> /etc/php/7.3/apache2/php.ini
RUN mkdir -p /var/log/php && touch /var/log/php/error.log && chmod 777 /var/log/php/error.log

# Map lnmail and lnmail.com to localhost
COPY lnmail/hosts /etc/hosts

RUN echo "myhostname = lnmail.com" >> /etc/postfix/main.cf && \
    echo "mydestination = lnmail.com" >> /etc/postfix/main.cf && \
    echo "inet_interfaces = all" >> /etc/postfix/main.cf && \
    echo "home_mailbox = Maildir/" >> /etc/postfix/main.cf && \
    echo "smtpd_tls_security_level = none" >> /etc/postfix/main.cf && \
    echo "smtpd_sasl_type = dovecot" >> /etc/postfix/main.cf && \
    echo "smtpd_sasl_path = private/auth" >> /etc/postfix/main.cf && \
    echo "smtpd_sasl_auth_enable = yes" >> /etc/postfix/main.cf && \
    echo "smtpd_tls_security_level = may" >> /etc/postfix/main.cf && \
    echo "smtpd_recipient_restrictions = permit_sasl_authenticated,permit_mynetworks,reject_unauth_destination" >> /etc/postfix/main.cf && \
    echo "auth_username_format = %Ln" >> /etc/dovecot/conf.d/10-auth.conf && \
    echo "disable_plaintext_auth = no" >> /etc/dovecot/conf.d/10-auth.conf && \
    echo "mail_location = maildir:~/Maildir" >> /etc/dovecot/conf.d/10-mail.conf && \
    echo "userdb {" >> /etc/dovecot/conf.d/10-auth.conf && \
    echo "  driver = passwd-file" >> /etc/dovecot/conf.d/10-auth.conf && \
    echo "  args = scheme=PLAIN username_format=%u /etc/dovecot/users" >> /etc/dovecot/conf.d/10-auth.conf && \
    echo "}" >> /etc/dovecot/conf.d/10-auth.conf && \
    echo "passdb {" >> /etc/dovecot/conf.d/10-auth.conf && \
    echo "  driver = passwd-file" >> /etc/dovecot/conf.d/10-auth.conf && \
    echo "  args = scheme=PLAIN username_format=%u /etc/dovecot/users" >> /etc/dovecot/conf.d/10-auth.conf && \
    echo "}" >> /etc/dovecot/conf.d/10-auth.conf && \
    echo "john:{PLAIN}pass:1000:1000::/home/john::" >> /etc/dovecot/users && \
    echo "alice:{PLAIN}pass:1001:1001::/home/alice::" >> /etc/dovecot/users && \
    echo "keycloak:{PLAIN}pass:1001:1001::/home/keycloak::" >> /etc/dovecot/users && \
    echo "admin:{PLAIN}pass:1001:1001::/home/admin::" >> /etc/dovecot/users && \
    echo "user:{PLAIN}pass:1001:1001::/home/user::" >> /etc/dovecot/users && \
    echo "mauricio:{PLAIN}pass:1001:1001::/home/mauricio::" >> /etc/dovecot/users && \
    echo "cesar:{PLAIN}pass:1001:1001::/home/cesar::" >> /etc/dovecot/users && \
    echo "renata:{PLAIN}pass:1001:1001::/home/renata::" >> /etc/dovecot/users && \
    echo "luis:{PLAIN}pass:1001:1001::/home/luis::" >> /etc/dovecot/users && \
    echo "fabio:{PLAIN}pass:1001:1001::/home/fabio::" >> /etc/dovecot/users && \
    echo "guilherme:{PLAIN}pass:1001:1001::/home/guilherme::" >> /etc/dovecot/users && \
    useradd -m -d /home/john -s /bin/bash john && \
    useradd -m -d /home/alice -s /bin/bash alice && \
    useradd -m -d /home/keycloak -s /bin/bash keycloak && \
    useradd -m -d /home/admin -s /bin/bash admin && \
    useradd -m -d /home/user -s /bin/bash user && \
    useradd -m -d /home/mauricio -s /bin/bash mauricio && \
    useradd -m -d /home/cesar -s /bin/bash cesar && \
    useradd -m -d /home/renata -s /bin/bash renata && \
    useradd -m -d /home/luis -s /bin/bash luis && \
    useradd -m -d /home/fabio -s /bin/bash fabio && \
    useradd -m -d /home/guilherme -s /bin/bash guilherme

# Add Postfix authentication configuration for Dovecot
COPY lnmail/dovecot-postfix-auth.conf /etc/dovecot/conf.d/    

# Enable Roundcube site and disable default
RUN a2dissite 000-default.conf && \
    echo "Alias / /var/lib/roundcube/" > /etc/apache2/sites-available/roundcube.conf && \
    echo "<Directory /var/lib/roundcube/>" >> /etc/apache2/sites-available/roundcube.conf && \
    echo "    Options +FollowSymLinks" >> /etc/apache2/sites-available/roundcube.conf && \
    echo "    AllowOverride All" >> /etc/apache2/sites-available/roundcube.conf && \
    echo "</Directory>" >> /etc/apache2/sites-available/roundcube.conf && \
    a2ensite roundcube

# Enable mod_rewrite for Roundcube
RUN a2enmod rewrite

# Start the services and keep the container running
CMD service apache2 start && service dovecot start && service postfix start && service mysql start && tail -f /dev/null
