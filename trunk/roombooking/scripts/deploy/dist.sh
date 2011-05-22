#!/bin/sh

EXPECTED_ARGS=1
REPO=https://roombooking.googlecode.com/svn/trunk


if [ $# -ne $EXPECTED_ARGS ]
then
	echo "Usage: `basename $0` {local/live}"
	exit 1
fi

if [ "$1" = "local" ]; then
	echo local
else
if [ "$1" = "live" ]; then
	echo Deploy heyidlebooks to live
	TMP=`mktemp -d`
	cd $TMP
	echo svn pass hJ3be8Gr3JF6
	/usr/bin/svn export $REPO --username=james || exit 1
	echo Login to dev.fullhaus.se 45817
	rsync -vazr --exclude-from='/home/james/projects/roombooking/scripts/deploy/rsync_exclude' trunk/roombooking/* james@dev.fullhaus.se:/home/james/html/booking/ || exit 3
	#echo cp content from public to public_html
	#ssh heyidleb@www.heyidlebooks.com 'cp -r /home/heyidleb/public/* /home/heyidleb/public_html/'
	#echo rm public folder
	#ssh heyidleb@www.heyidlebooks.com 'rm -r /home/heyidleb/public/'
	cd ..
	rm -rf $TMP || exit 4 
fi
fi

exit 0