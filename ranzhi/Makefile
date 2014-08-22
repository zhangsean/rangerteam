VERSION=$(shell head -n 1 VERSION)

all: ranzhi
clean:
	rm -fr ranzhi
	rm -fr *.zip
ranzhi:
	mkdir ranzhi
	cp -fr app ranzhi/
	cp -fr bin ranzhi/
	cp -fr config ranzhi/ && rm -fr ranzhi/config/my.php
	mkdir ranzhi/db
	cp -fr db/*.sql ranzhi/db/
	cp -fr doc ranzhi/ && rm -fr ranzhi/doc/phpdoc && rm -fr ranzhi/doc/doxygen
	cp -fr framework ranzhi/
	cp -fr lib ranzhi/
	cp -fr tmp ranzhi
	rm -fr ranzhi/db/temp.sql
	rm -fr ranzhi/tmp/cache/* 
	rm -fr ranzhi/tmp/extension/*
	rm -fr ranzhi/tmp/log/*
	rm -fr ranzhi/tmp/model/*
	cp -fr www ranzhi && rm -fr ranzhi/www/data/ && mkdir -p ranzhi/www/data/upload
	cp VERSION ranzhi/
	# combine js and css files.
	cp -fr tools ranzhi/tools && cd ranzhi/tools/ && php ./minifyfront.php
	rm -fr ranzhi/tools
	# delete the useless files.
	find ranzhi -name .svn |xargs rm -fr
	find ranzhi -name tests |xargs rm -fr
	for path in `find ranzhi/ -type d`; do touch "$$path/index.php"; done	
	# change mode.
	chmod 777 -R ranzhi/tmp/
	chmod 777 -R ranzhi/www/data
	chmod 777 -R ranzhi/config
	#chmod a+rx ranzhi/bin/*
	#find ranzhi/ -name ext |xargs chmod -R 777
	# zip it.
	zip -rm -9 ranzhi.$(VERSION).zip ranzhi
