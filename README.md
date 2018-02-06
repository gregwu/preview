# preview
preview files

PHP rewrite of this node.js project (https://github.com/maxlabelle/filepreview ).


Install Third Party Software on CentOS


1. Install FFmpeg
-----------------------------------------------------------
https://www.vultr.com/docs/how-to-install-ffmpeg-on-centos

Step 1: update the system

sudo yum install epel-release -y

sudo yum update -y

sudo shutdown -r now

Step 2: Install the Nux Dextop YUM repo

sudo rpm --import http://li.nux.ro/download/nux/RPM-GPG-KEY-nux.ro

sudo rpm -Uvh http://li.nux.ro/download/nux/dextop/el6/x86_64/nux-dextop-release-0-2.el6.nux.noarch.rpm

Step 3: Install FFmpeg and FFmpeg development packages

sudo yum install ffmpeg ffmpeg-devel -y

2. Install ImageMagic
-----------------------------------------------------------
https://www.vultr.com/docs/install-imagemagick-on-centos-6/

If you have not installed the epel repository, install it now.

wget http://dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm

rpm -Uvh epel-release-6*.rpm

Next, install the remi repository:

wget http://rpms.famillecollet.com/enterprise/remi-release-6.rpm

rpm -Uvh remi-release-6*.rpm

An additional step is required to enable the remi repository:

Use your favorite text editor to open /etc/yum.repos.d/remi.repo. Look for the remi section and find enabled=0 and change it to enabled=1.

Make sure that the required dependencies are installed:

yum install -y gcc php-devel php-pear

Then install ImageMagick:

yum install -y ImageMagick ImageMagick-devel

in addtion: https://www.liaohuqiu.net/posts/install-php-imagick-on-centos/


3. Install  unoconv
-----------------------------------------------------------
https://drujoopress.wordpress.com/2014/07/10/how-to-install-unoconv-in-centos-6-5/

1. create file  /etc/yum.repos.d/Archives.repo

####################################################

[c6-archives]

name=CentOS-6 – Archives

baseurl=http://vault.centos.org/6.2/updates/$basearch/

gpgcheck=0

enabled=1

####################################################

2. run

sudo yum clean all

sudo yum install unoconv openoffice.org-headless openoffice.org-writer openoffice.org-calc openoffice.org-impress
