include:
  - apache2
  
/etc/apache2/sites-available/directorzone.conf:
  file:
    - managed
    - source: salt://files/directorzone.conf
    - template: jinja
    - require:
      - sls: apache2
      
/var/www/directorzone/config/autoload/local.php:
  file:
    - managed
    - source: salt://files/directorzone/config/local.jinja
    - template: jinja
    - user: www-data
    - group: www-data
    - mode: {{ pillar['zf2']['configfiles']['mode'] }}

/var/www/directorzone/config/autoload/netsensia.local.php:
  file:
    - managed
    - source: salt://files/directorzone/config/netsensia.local.jinja
    - template: jinja
    - user: www-data
    - group: www-data
    - mode: {{ pillar['zf2']['configfiles']['mode'] }}