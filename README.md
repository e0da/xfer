Requirements
============

To install all requirements and configure the environment in Ubuntu, do

    sudo aptitude update
    sudo aptitude upgrade -y
    sudo aptitude -y install apache2 libapache2-mod-php5
    sudo a2enmod authnz_ldap
    sudo a2dismod php5
    sudo a2enmod php5

Yes, you have to disable then enable PHP on fresh Ubuntu installations or it just does not work.

Then set up your keys

    sudo -u www-data -i
    cd /var/www
    ssh-keygen
    cat .ssh/id_rsa.pub # Copy this key into your public keys on Redmine

Then clone the repository (you may need to adjust the URL)

    git clone git@redmine:xfer.git

That is all.

