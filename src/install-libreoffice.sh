# Download LibreOffice_5.3.7
sudo wget http://free.nchc.org.tw/tdf/libreoffice/stable/5.3.7/deb/x86_64/LibreOffice_5.3.7_Linux_x86-64_deb.tar.gz
# Unzip this package
sudo tar -zxvf LibreOffice_5.3.7_Linux_x86-64_deb.tar.gz
# Install All debs
sudo dpkg -i ./LibreOffice_5.3.7.2_Linux_x86-64_deb/DEBS/*.deb
# Test version
sudo libreoffice --version
