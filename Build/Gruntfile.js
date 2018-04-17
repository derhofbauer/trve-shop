module.exports = function(grunt) {

    /**
     * Project configuration.
     */
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        paths: {
            root: '../',
            src: '<%= paths.root %>src/',
            less: '<%= paths.src %>resources/assets/less/',
            sass: '<%= paths.src %>resources/assets/sass/',
            css: '<%= paths.src %>public/css/',
            fonts: '<%= paths.src %>public/fonts/',
            img: '<%= paths.src %>public/images/',
            js_src: '<%= paths.src %>resources/assets/js/',
            js: '<%= paths.src %>public/js/'
        },
        banner: '/*!\n' +
        ' * Trve Shop v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
        ' * Copyright 2017-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
        ' * Licensed under the <%= pkg.license %> license\n' +
        ' */\n',
        uglify: {
            all: {
                options: {
                    banner: '<%= banner %>',
                    mangle: true,
                    compress: true,
                    beautify: false
                },
                files: {
                    "<%= paths.js %>app.js": [
                        "<%= paths.js_src %>app.js"
                    ]
                }
            }
        },
        less: {
            layout: {
                src: '<%= paths.less %>layout.less',
                dest: '<%= paths.css %>layout.css'
            }
        },
        sass: {
            app: {
                options: {
                    style: 'compressed',
                    noCache: true
                },
                files: {
                    '<%= paths.css %>app.min.css': '<%= paths.sass %>app.scss'
                }
            }
        },
        postcss: {
            options: {
                map: false,
                processors: [
                    require('autoprefixer')({
                        browsers: [
                            'Last 2 versions',
                            'Firefox ESR',
                            'IE 9'
                        ]
                    })
                ]
            },
            layout: {
                src: '<%= paths.css %>layout.css'
            }
        },
        cssmin: {
            options: {
                keepSpecialComments: '*',
                advanced: false
            },
            layout: {
                src: '<%= paths.css %>layout.css',
                dest: '<%= paths.css %>layout.min.css'
            }
        },
        image: {
            extension: {
                files: [{
                    expand: true,
                    cwd: '<%= paths.resources %>',
                    src: [
                        '**/*.{png,jpg,gif,svg}'
                    ],
                    dest: '<%= paths.resources %>'
                }]
            }
        },
        watch: {
            options: {
                livereload: true
            },
            less: {
                files: '<%= paths.less %>**/*.less',
                tasks: ['less', 'postcss', 'cssmin']
            },
            sass: {
                files: '<%= paths.sass %>**/*.scss',
                tasks: ['sass']
            },
            javascript: {
                files: '<%= paths.js_src %>**/*.js',
                tasks: ['js']
            }
        }
    });

    /**
     * Register tasks
     */
    grunt.loadNpmTasks('grunt-contrib-uglify-es');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-image');

    /**
     * Grunt update task
     */
    grunt.registerTask('css', ['less', 'sass', 'postcss', 'cssmin']);
    grunt.registerTask('js', ['uglify']);
    grunt.registerTask('build', ['js', 'css', 'image']);
    grunt.registerTask('default', ['build']);

};