apache:
  pkg:
    - installed
    - pkgs:
      - apache2
      - libapache2-mod-php5
      
apache2:
  service:
    - running
    - require:
      - pkg: apache
