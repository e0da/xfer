Requirements
============

To install all requirements and configure the environment in Ubuntu:

    sudo aptitude update
    sudo aptitude upgrade -y
    sudo aptitude -y install apache2 libapache2-mod-php5
    sudo a2enmod authnz_ldap
    sudo a2dismod php5
    sudo a2enmod php5
    sudo chown -R www-data:www-data /var/www

Yes, you have to disable then enable PHP on fresh Ubuntu installations or it just does not work.

Then set up your keys, clone the repository, and create the share folder:

    sudo -u www-data -i
    cd /var/www
    ssh-keygen
    cat .ssh/id_rsa.pub # Copy this key into your public keys on Redmine
    git clone git@redmine:xfer.git
    mkdir xfer/share

