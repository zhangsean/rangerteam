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
	cp -fr db ranzhi/
	cp -fr doc ranzhi/ && rm -fr ranzhi/doc/phpdoc && rm -fr ranzhi/doc/doxygen
	cp -fr framework ranzhi/
	cp -fr lib ranzhi/
	cp -fr tmp ranzhi
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
	# change mode.
	chmod 777 -R ranzhi/tmp/
	chmod 777 -R ranzhi/www/data
	chmod 777 -R ranzhi/config
	#chmod a+rx ranzhi/bin/*
	#find ranzhi/ -name ext |xargs chmod -R 777
	# remove the module that is not release.
	rm -rf ranzhi/app/cash
	rm -rf ranzhi/app/sns
	rm -rf ranzhi/www/cash
	rm -rf ranzhi/www/sns
	# zip it.
	zip -rm -9 RanZhi.$(VERSION).zip ranzhi
