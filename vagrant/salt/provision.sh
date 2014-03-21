#!/bin/bash
apt-get -y install python-software-properties
add-apt-repository ppa:saltstack/salt
apt-get -y update
apt-get -y install salt-minion
sed -i 's/#master: salt/master: salt-master.netsensia.com/g' /etc/salt/minion
NOW=$(date +"%Y-%m-%d-%H-%M")
sed -i "s/#id:/id: directorzone_vagrant_$NOW/g" /etc/salt/minion
sed -i 's/#master: salt/master: salt-master.netsensia.com/g' /etc/salt/minion
