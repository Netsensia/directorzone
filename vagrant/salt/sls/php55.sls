php55_ondrej:
  pkgrepo.managed:
    - ppa: ondrej/php5
    
php55:
  pkg.latest:
    - refresh: True
    - require:
      - pkgrepo: php55_ondrej
    - pkgs:
      - python-software-properties
      - php5-curl
      - php5-mcrypt
      - php5-xsl
      - php5-ldap
      - php5-mysql
      - php5-gd
      - php5-intl
      - php5-json

