'use strict';
module.exports = function(grunt) {

	// load all grunt tasks matching the `grunt-*` pattern
	require('load-grunt-tasks')(grunt);

	grunt.initConfig({

		// watch for changes and trigger sass, jshint, uglify and livereload
		watch: {
			sass: {
				files: ['assets/scss/*.{scss,sass}', 'assets/scss/**/*.{scss,sass}'],
				tasks: ['sass', 'autoprefixer', 'cssmin']
			},
			js: {
				files: '<%= jshint.all %>',
				tasks: ['jshint', 'uglify']
			},
			images: {
				files: ['assets/images/**/*.{png,jpg,gif}'],
				tasks: ['imagemin']
			}
		},

		// sass
		sass: {
			dist: {
				options: {
					style: 'compressed',
				},
				files: {
					'assets/css/main.css': 'assets/scss/main.scss',
					'assets/css/admin.css': 'assets/scss/admin.scss'
				}
			}
		},

		// autoprefixer
		autoprefixer: {
			options: {
				browsers: ['last 2 versions', 'ie 9', 'ios 7', 'android 4'],
				map: true
			},
			files: {
				expand: true,
				flatten: true,
				src: 'assets/css/build/*.css',
				dest: 'assets/css/build'
			},
		},

		// css minify
		cssmin: {
			options: {
				keepSpecialComments: 1
			},
			minify: {
				expand: true,
				cwd: 'assets/css/build',
				src: ['*.css', '!*.min.css'],
				ext: '.css'
			}
		},

		// javascript linting with jshint
		jshint: {
			options: {
				jshintrc: '.jshintrc',
				'force': true
			},
			all: [
				'Gruntfile.js',
				'assets/js/source/**/*.js'
			]
		},

		// uglify to concat, minify, and make source maps
		uglify: {
			plugins: {
				options: {
					sourceMap: 'assets/js/plugins.js.map',
					sourceMappingURL: 'plugins.js.map',
					sourceMapPrefix: 2
				},
				files: {
					'assets/js/plugins.min.js': [
						'assets/js/vendor/*.js'
					]
				}
			},
			main: {
				options: {
					sourceMap: 'assets/js/main.js.map',
					sourceMappingURL: 'main.js.map',
					sourceMapPrefix: 2
				},
				files: {
					'assets/js/main.min.js': [
						'assets/js/source/main.js'
					]
				}
			}
		},

		// image optimization
		imagemin: {
			dist: {
				options: {
					optimizationLevel: 7,
					progressive: true,
					interlaced: true
				},
				files: [{
					expand: true,
					cwd: 'assets/images/',
					src: ['**/*.{png,jpg,gif}'],
					dest: 'assets/images/'
				}]
			}
		},

		// browserSync
		browserSync: {
			dev: {
				bsFiles: {
					src : ['style.css', 'assets/js/*.js', 'assets/images/**/*.{png,jpg,jpeg,gif,webp,svg}']
				},
				options: {
					proxy: 'local.dev',
					watchTask: true
				}
			}
		},

		// deploy via rsync
		deploy: {
			options: {
				src: './',
				args: ['--verbose'],
				exclude: [
					'.git*',
					'*.scss',
					'*.sass',
					'node_modules',
					'.sass-cache',
					'Gruntfile.js',
					'package.json',
					'.DS_Store',
					'README.md',
					'config.rb',
					'.jshintrc',
					'.travis.yml'
				],
				recursive: true,
				syncDestIgnoreExcl: true
			},
			staging: {
				 options: {
					dest: '~/path/to/theme',
					host: 'user@host.com'
				}
			},
			production: {
				options: {
					dest: '~/path/to/theme',
					host: 'user@host.com'
				}
			}
		}

	});

	// rename tasks
	grunt.renameTask('rsync', 'deploy');

	// register task
	grunt.registerTask('default', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'imagemin', 'watch']);

};