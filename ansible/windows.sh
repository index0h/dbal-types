#!/usr/bin/env bash

sudo yum install -y http://dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm
sudo yum install -y --nogpgcheck ansible

sudo cp /vagrant/ansible/inventories/dev /etc/ansible/hosts -f
sudo ansible-playbook /vagrant/ansible/playbook.yml -e hostname=$1 --connection=local -v