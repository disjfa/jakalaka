module.exports = function (grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        copy: {
            options: {},
            build: {
                expand: true,
                flatten: true,
                filter: 'isFile',
                src: 'node_modules/font-awesome/fonts/*',
                dest: 'web/glynn-admin/fonts'
            }
        },
        jshint: {
            options: {
                reporter: require('jshint-stylish'),
                esversion: 6
            },
            all: [
                'Gruntfile.js',
                'web/glynn-admin/assets/**/*.js'
            ]
        },
        browserify: {
            dist: {
                options: {
                    transform: [
                        [
                            'babelify',
                            {
                                presets: ['es2015']
                            }
                        ],
                        'vueify',
                        'aliasify'
                    ],
                    browserifyOptions: {
                        debug: true
                    },
                    exclude: '',
                    watch: true
                },
                files: {
                    'web/glynn-admin/js/glynn-admin.js': ['web/glynn-admin/assets/glynn-admin.js']
                }
            }
        },
        uglify: {
            options: {
                report: 'min',
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                files: {
                    'web/glynn-admin/js/glynn-admin.min.js': ['web/glynn-admin/js/glynn-admin.js']
                }
            }
        },
        sasslint: {
            options: {
                configFile: '.sass-lint.yml'
            },
            target: [
                'web/glynn-admin/sass/app.scss',
                'web/glynn-admin/sass/**/*.scss'
            ]
        },
        sass: {
            dist: {
                options: {
                    style: 'expanded',
                    loadPath: 'node_modules'
                },
                files: {
                    'web/glynn-admin/css/glynn-admin.css': 'web/glynn-admin/scss/glynn-admin.scss'
                }
            }
        },

        cssmin: {
            options: {
                report: 'min',
                root: 'web',
                target: 'web',
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                files: {
                    'web/glynn-admin/css/glynn-admin.min.css': 'web/glynn-admin/css/glynn-admin.css'
                }
            }
        },

        clean: [
            'web/glynn-admin/css/*',
            'web/glynn-admin/fonts/*',
            'web/glynn-admin/js/*'
        ],

        watch: {
            sass: {
                files: 'web/glynn-admin/**/*.scss',
                tasks: ['sasslint', 'sass'],
                options: {
                    debounceDelay: 250
                }
            },
            assets: {
                files: 'web/glynn-admin/assets/**/*.js',
                tasks: ['jshint', 'browserify'],
                options: {
                    debounceDelay: 250
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-sass-lint');
    grunt.loadNpmTasks('grunt-vueify');


    grunt.registerTask('default', ['clean', 'copy', 'jshint', 'browserify', 'sasslint', 'sass']);
    grunt.registerTask('watcher', ['default', 'watch']);
    grunt.registerTask('prod', ['clean', 'copy', 'jshint', 'browserify', 'uglify', 'sasslint', 'sass', 'cssmin']);
};