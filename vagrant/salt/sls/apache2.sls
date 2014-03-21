apache2:
  pkg:
    - installed
    - pkgs:
      - apache2
      - libapache2-mod-php5
  service:
    - running
    - require:
      - pkg: apache2

apache2-reload:
  module:
    - wait
    - name: service.reload
    - m_name: apache2

apache2-restart:
  module:
    - wait
    - name: service.restart
    - m_name: apache2
          
a2enmod rewrite:
  cmd.run:
    - unless: ls /etc/apache2/mods-enabled/rewrite.load
    - order: 225
    - require:
      - pkg: apache2
    - watch_in:
      - module: apache2-restart

