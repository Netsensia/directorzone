#!/bin/bash
apt-get -y install python-software-properties
add-apt-repository ppa:saltstack/salt
apt-get -y update
apt-get -y install salt-minion
sed -i 's/#master: salt/master: salt-master.netsensia.com/g' /etc/salt/minion
NOW=$(date +"%Y-%m-%d-%H-%M")
sed -i "s/#id:/id: directorzone_vagrant_$NOW/g" /etc/salt/minion
sed -i 's/#master: salt/master: salt-master.netsensia.com/g' /etc/salt/minion

sh -c 'echo "echo 1 > /proc/sys/vm/drop_caches" >> /home/vagrant/drop_caches'
sudo chmod +x /home/vagrant/drop_caches

echo 100 > /proc/sys/vm/dirty_expire_centisecs
echo 100 > /proc/sys/vm/dirty_writeback_centisecs

