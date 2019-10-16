# run in the Host OS. run as root

if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 
   exit 1
fi

cd ./var
find . -type d -exec chmod 777 {} \;
find . -type f -exec chmod 666 {} \;

cd ../media
find . -type d -exec chmod 777 {} \;
find . -type f -exec chmod 666 {} \;

cd ../lib
find . -type d -exec chmod 755 {} \; 
find . -type f -exec chmod 666 {} \;

cd ../app
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 666 {} \;

cd ../errors
find . -type d -exec chmod 755 {} \; 
find . -type f -exec chmod 666 {} \;

cd ../downloader
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 666 {} \;

cd ../skin
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 666 {} \;

cd ../store
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 666 {} \;

cd ../includes
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 666 {} \;

cd ../pkginfo
find . -type d -exec chmod 755  {} \;
find . -type f -exec chmod 666 {} \;

cd ../shell
find . -type d -exec chmod 755  {} \;
find . -type f -exec chmod 666 {} \;


