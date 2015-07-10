'use strict';
module.exports = function(grunt) {

	// Load all grunt tasks matching the `grunt-*` pattern
	require('load-grunt-tasks')(grunt);

	grunt.initConfig({

		// Watch for changes and trigger sass, jshint, uglify and livereload
		watch: {
			sass: {
				files: ['assets/scss/*.{scss,sass}', 'assets/scss/**/*.{scss,sass}'],
				tasks: ['sass']
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

		// SCSS
		sass: {
			dist: {
				options: {
					style: 'compressed',
				},
				files: {
					'assets/css/main.css': 'assets/scss/main.scss',
					'assets/css/vendor.css': 'assets/scss/vendor.scss',
					'assets/css/admin.css': 'assets/scss/admin.scss',
					'assets/css/admin/editor.css': 'assets/scss/admin/editor.scss',
					'assets/css/admin/login.css': 'assets/scss/admin/login.scss'
				}
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

		// Uglify to concat, minify, and make source maps
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

		// Image optimization
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

		// Deploy via rsync
		deploy: {
			options: {
				src: './',
				args: ['--verbose'],
				exclude: [
					'.git*',
					'*.scss',
					'*.sass',
					'*.map',
					'node_modules',
					'.sass-cache',
					'.gitignore',
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

	// Rename tasks
	grunt.renameTask('rsync', 'deploy');

	// Register task
	grunt.registerTask('default', ['sass', 'uglify', 'imagemin', 'watch']);

};