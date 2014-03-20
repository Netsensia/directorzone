apt-get -y install python-software-properties
add-apt-repository ppa:saltstack/salt
apt-get -y update
apt-get -y install salt-minion
sed -i 's/#master: salt/master: salt-master.netsensia.com/g' /etc/salt/minion



