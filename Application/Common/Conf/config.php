<?php
return array(
	//'配置项'=>'配置值'
        'DB_TYPE'   => 'mysql', // 数据库类型
        'DB_HOST'   => '121.40.92.106', // 服务器地址
        'DB_NAME'   => 'student', // 数据库名
        //'DB_USER'   => 'outspace', // 用户名
       // 'DB_PWD'    => 'qazwsxcms', //
		'DB_USER' => 'root',
		'DB_PWD' => 'xj19931027',
        'DB_PORT'   => 3306, // 端口
        'DB_PREFIX' => '', // 数据库表前缀
        'DB_CHARSET'=> 'utf8', // 字符集
        'URL_HTML_SUFFIX'=>'html',//伪静态
		'tmpl_l_delim'=>'<{',
		'tmpl_r_delim'=>'}>',
		'show_page_trace'=> false,
     	'tmpl_cache_on'  =>  false,
		'URL_MODEL'=>2,
		//Memcache缓存
		'DATA_CACHE_TYPE' => 'Memcache',	//设置默认缓存类型
		'DATA_CACHE_PREFIX' => 'think',		//设置缓存前缀
		'MEMCACHED_HOST' => '127.0.0.1',	//ip
		'MEMCACHED_PORT' => '11211',		//port
		'DATA_CACHE_TIME' => '3600',			//缓存生效时间
);