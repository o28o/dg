cd /var/www/html/suttacentral.net/sc-data/sc_bilara_data/root/pli/ms/

find . -type f -exec sed -i 's@</\?[bi]>@@g' {} +
