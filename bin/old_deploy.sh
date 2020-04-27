# Setup
lftp -c "open -u $FTP_USER,$FTP_PASS ftp://35.169.23.154/; set ssl:verify-certificate no; mirror -R . P2A"
