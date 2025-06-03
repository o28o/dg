#!/bin/bash

sudo apt update && sudo apt -y upgrade
sudo apt install -y apache2 php zip pv wget git jq
sudo apt install -y php-{common,xml,xmlrpc,curl,gd,imagick,cli,dev,imap,mbstring,opcache,soap,zip,intl}
rm /var/www/html/index.html
cd /var/www/html
git clone https://github.com/o28o/fdg.git ./
mkdir result
cd ru && ln -s ../result ./ && cd ..
cd ..

chown -R apache:apache /var/www/html 
chown -R www-data:www-data /var/www/html 

mkdir suttacentral.net && cd suttacentral.net
git clone https://github.com/suttacentral/sc-data.git 

echo "downloading offline data"
cd ..
git@github.com:o28o/dg-offline-data.git
mv dg-offline-data offline-data

echo "optionally you can donwload pali audio sc-voice data
cd to the dhamma.gift project folder (apache default folder)
git clone https://github.com/o28o/dg.audio ./assets/audio
"


chown -R apache:apache /var/www/suttacentral.net
chown -R www-data:www-data /var/www/suttacentral.net

sudo systemctl restart apache2


#check this or similar article for "how to check apache and php installation"
# https://www.vultr.com/docs/install-linux-apache-mysql-and-php-lamp-on-ubuntu-20-04-lts/

#vmtouch -vfldt ./suttacentral.net/sc-data/html_text/ru ./suttacentral.net/sc-data/sc_bilara_data/root/pli/ms/sutta/ ./suttacentral.net/sc-data/sc_bilara_data/root/pli/ms/vinaya/ ./suttacentral.net/sc-data/sc_bilara_data/translation/en/brahmali/ ./suttacentral.net/sc-data/sc_bilara_data/translation/en/sujato/ ./theravada.ru/Teaching/Canon/Suttanta/ ./tipitaka.theravada.su/ ./assets/js/ ./assets/css/ ./assets/texts/ ./assets/example ./assets/templates ./index.php ./read.php ./read/ ./scripts/ ./db/fdg-db.db

#/var/www/html/ ./result

exit 0

cp -par ./suttacentral.net/sc-data/sc_bilara_data/root/pli/ms/sutta/ /tmp/sutta
cp -par ./suttacentral.net/sc-data/sc_bilara_data/variant/pli/ms/sutta/ /tmp/variants
cp -par ./suttacentral.net/sc-data/sc_bilara_data/translation/en/sujato/ /tmp/sujato

./suttacentral.net/sc-data/sc_bilara_data/root/pli/ms/vinaya/
./suttacentral.net/sc-data/sc_bilara_data/translation/en/brahmali/
 ./theravada.ru/Teaching/Canon/Suttanta/ ./tipitaka.theravada.su/ ./assets/js/ ./assets/css/ ./assets/texts/ ./assets/example ./assets/templates ./index.php ./read.php ./read/ ./scripts/ ./db/fdg-db.db
