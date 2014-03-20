include:
  - apache2
  
/etc/apache2/sites-available/directorzone.conf:
  file:
    - managed
    - source: salt://files/directorzone.conf
    - template: jinja
    - require:
      - sls: apache2