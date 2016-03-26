# -*- mode: ruby -*-
# vi: set ft=ruby :

def which(cmd)
    exts = ENV['PATHEXT'] ? ENV['PATHEXT'].split(';') : ['']
    ENV['PATH'].split(File::PATH_SEPARATOR).each do |path|
        exts.each { |ext|
            exe = File.join(path, "#{cmd}#{ext}")
            return exe if File.executable? exe
        }
    end
    return nil
end

VAGRANTFILE_API_VERSION = '2'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  if Vagrant.has_plugin?('vagrant-vbguest') then
    config.vbguest.auto_update = false
  end

  config.ssh.forward_agent = true

  config.vm.box = 'puppetlabs/centos-6.6-64-nocm'
  config.vm.hostname = 'doctrine-types'

  config.vm.network 'private_network', ip: '192.168.100.143'

  config.vm.provider 'virtualbox' do |vb|
    vb.name = 'doctrine-types'
    vb.customize [
      'modifyvm', :id,
      '--memory', '1024',
      '--ioapic', 'on',
      '--natdnshostresolver1', 'on',
      '--cpus', 2,
    ]
  end

  # If ansible is in your path it will provision from your HOST machine
  # If ansible is not found in the path it will be instaled in the VM and provisioned from there
  if which('ansible-playbook')
    config.vm.provision 'ansible' do |ansible|
      ansible.playbook = 'ansible/playbook.yml'
      ansible.inventory_path = 'ansible/inventories/dev'
      ansible.limit = 'all'
      ansible.host_key_checking = false
      # ansible.verbose = 'vvvv'
    end
  else
   config.vm.provision :shell, path: 'ansible/windows.sh', args: ['doctrine-types']
  end
end
