ssh -i "/Volumes/Boxcryptor/Dropbox/Encrypted/Security/Keys/Amazon EC2/DirectorzoneSaltTrusty.pem" ubuntu@54.76.116.80 "sudo rm -rf /home/ubuntu/upload/* && sudo cp -R /var/www/directorzone/public/img/upload/* /home/ubuntu/upload && cd /home/ubuntu/upload && tar -zcvf upload.tar.gz *"
scp -i "/Volumes/Boxcryptor/Dropbox/Encrypted/Security/Keys/Amazon EC2/DirectorzoneSaltTrusty.pem" ubuntu@54.76.116.80:upload.tar.gz /Users/Chris/git/directorzone/public/img
cd /Users/Chris/git/directorzone/public/img
tar -zxvf upload.tar.gz
rm upload.tar.gz

 
